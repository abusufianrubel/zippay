<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\AgentWallet;
use Modules\Agent\Services\AgentService;
use Modules\Agent\Transformers\AgentResource;
use App\Http\Controllers\Users\EmailController;
use Modules\Agent\Transformers\AgentWalletResource;
use Modules\Agent\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UploadUserProfilePictureRequest;

class ProfileController extends Controller
{
    protected $agent;
    protected $email;
    protected $agentId;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
        $this->agentId = isset(auth('agent-v2')->user()->id) ? auth('agent-v2')->user()->id : '';
        $this->email = new EmailController();
    }

    public function show()
    {
        try {
            $agent = $this->agent->findByIdWithWallets($this->agentId);
            $data['agent'] = (new AgentResource($agent));
            $data['countries'] = Country::orderBy('name', 'asc')->get();
            $data['timezones'] = phpDefaultTimeZones();
            $data['wallets'] = AgentWalletResource::collection(AgentWallet::getAgentWallet($this->agentId));
            $data['defaultWallet'] = AgentWallet::with('currency')
                                        ->where('agent_id', $this->agentId)
                                        ->where('is_default', 'Yes')->first();

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse($e->getMessage());
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $agent = (new AgentService())->updateAgent($this->agentId, $request->all());
            return $this->successResponse((new AgentResource($agent)));
        } catch (Exception $e) {
            return $this->unprocessableResponse([], $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required','string','min:6'],
                'password' => ['required','string','min:6','different:current_password', 'confirmed'],
            ]);

            if (Hash::check($validated['current_password'], auth('agent-v2')->user()->password)) {
                $data = auth('agent-v2')->user()->update([
                    'password' => Hash::make($validated['password']),
                ]);

                return $this->successResponse($data);
            } else {
                return $this->unprocessableResponse([], __('You have entered wrong current password.'));
            }
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    public function updateProfileImg(UploadUserProfilePictureRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $agent = auth('agent-v2')->user();
                $extension = strtolower($image->getClientOriginalExtension());

                if (!in_array($extension, getFileExtensions(3))) {
                    $fileExtensions = implode(", ", getFileExtensions(3));
                    return $this->unprocessableResponse(
                        [], 
                        __('The file must be an image (:x)', ['x' => $fileExtensions])
                    );
                }

                $response = uploadImage($image, Agent::$directory, '100*100', $agent->photo, '70*70');

                if (true === $response['status']) {
                    $agent->photo = $response['file_name'];
                }
                $agent->save();

                return $this->successResponse(
                    [
                        'image' => $agent->photo, 
                        'path' => url(Agent::$directory), 
                        'directory' => url(Agent::$directory). '/' .$agent->photo
                    ]
                );
            }
        } catch (Exception $e) {

            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    public function walletList()
    {
        try {
            $wallets = AgentWallet::getAgentWallet($this->agentId);

            $data['wallets'] = AgentWalletResource::collection($wallets);

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    public function defaultWallet(Request $request)
    {
        try {
            (new AgentService())->changeAgentDefaultWallet($this->agentId, $request->default_wallet); 
            return $this->successResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    public function destroy(Request $request)
    {
        try {
            $token = auth('agent-v2')->user()->token();
            if ($token) {
                $token->revoke();
            }

            return $this->successResponse(__('Successfully logout'));
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __($e->getMessage()));
        }
    }

    public function duplicatePhone()
    {
        try {
            $phone = preg_replace("/[\s-]+/", "", request()->phone);
            $phoneExist = Agent::where('phone', $phone)
                    ->whereNotIn('id', [$this->agentId])
                    ->exists();

            if($phoneExist){
                return $this->unprocessableResponse([], __('The phone has already been taken')); 
            }
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __($e->getMessage()));
        }


    }
}
