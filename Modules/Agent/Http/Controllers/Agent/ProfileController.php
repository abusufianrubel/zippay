<?php

namespace Modules\Agent\Http\Controllers\Agent;

use Exception;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Rules\CheckValidFile;
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\{
    DB,
    Auth,
    Validator
};
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\EmailController;
use Modules\Agent\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    protected $helper;
    protected $email;

    const AGENT_PROFILE_REDIRECT = 'agent/profile';

    public function __construct()
    {
        $this->helper = new Common();
        $this->email = new EmailController();
    }

    public function index()
    {
        try {
            $data = executeAgentApi('profile');
            $data['menu'] = 'profile';
            $data['sub_menu'] = 'profile';
            return view('agent::agent.profile.index', $data);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(self::AGENT_PROFILE_REDIRECT);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            executeAgentPostApi("check-duplicate-phone", $request);
            executeAgentPostApi("profile", $request);
            Common::one_time_message('success', __('Profile Updated Successfully'));
            return redirect(self::AGENT_PROFILE_REDIRECT);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(self::AGENT_PROFILE_REDIRECT);
        }

    }

    public function profileImage(Request $request)
    {
        return redirect(self::AGENT_PROFILE_REDIRECT);
    }

    public function imageUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => new CheckValidFile(getFileExtensions(3), true),
            ]
        );

        if ($validator->fails()) {
            return array(
                'fail'   => true,
                'errors' => $validator->errors(),
            );
        }

        $fileName = '';
        $agent = Agent::find(Auth::guard('agent')->user()->id);
        $oldPicture = $agent->photo ?? null;
        $picture = $request->file;

        if (isset($picture)) {
            $response = uploadImage($picture, base_path('/Modules/Agent/Resources/assets/images/profile/'),'100*100', $oldPicture, '70*70');
            if ($response['status'] === true) {
                $fileName = $response['file_name'];
            } else {
                DB::rollBack();
                Common::one_time_message('error', $response['message']);
                return back()->withErrors($validator)->withInput();
            }
        }
        if ($fileName != null) {
            $agent->photo = $fileName;
        }
        $agent->save();
        return $fileName;
    }

    public function walletList()
    {
        try {
            $data = executeAgentApi('wallet-list');
            $data['menu'] = 'profile';
            $data['sub_menu'] = 'wallets';

            return view('agent::agent.profile.wallet', $data);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(self::AGENT_PROFILE_REDIRECT);
        }
    }

    public function defaultWallet(Request $request)
    {
        try {
            executeAgentPostApi("wallet-make-default", $request);

            Common::one_time_message('success', __('Default Wallet Updated Successfully'));
            return redirect(self::AGENT_PROFILE_REDIRECT);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(self::AGENT_PROFILE_REDIRECT);
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        try {
            executeAgentPostApi("update-password", $request);
            
            Common::one_time_message('success', __('Password Updated Successfully'));
            return redirect(self::AGENT_PROFILE_REDIRECT);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect(self::AGENT_PROFILE_REDIRECT);
        }
    }

    public function duplicatePhoneCheck(Request $request)
    {
        try {
            $success = executeAgentPostApi("check-duplicate-phone", $request);
            return response()->json([
                'success' => $success,
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
