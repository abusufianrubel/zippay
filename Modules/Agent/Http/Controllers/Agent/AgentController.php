<?php

namespace Modules\Agent\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\{
    Hash,
    DB,
    Auth,
    Validator
};
use Modules\Agent\Entities\Agent;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Users\EmailController;
use App\Rules\CheckValidFile;
use Exception;
use Modules\Agent\Http\Requests\UpdateProfileRequest;

class AgentController extends Controller
{
    protected $helper;
    protected $email;

    public function __construct()
    {
        $this->helper = new Common();
        $this->email = new EmailController();
    }

    public function agentWallet()
    {
        $data['wallets'] = executeAgentApi('wallet-list');
        $data['menu'] = 'agentWallet';
        return view('agent::agent.agent_dashboard.agents.agentwallet', $data);
    }

    public function profile()
    {
        try {
            $data = executeAgentApi('profile');
            $data['menu'] = 'profile';
            $data['sub_menu'] = 'profile';
            return view('agent::agent.profile.index', $data);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect('agent/fail');
        }
    }

    public function updateProfilePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);

        $agent = Agent::where(['id' => Auth::guard('agent')->user()->id])->first();

        if (Hash::check($request->old_password, $agent->password)) {
            $agent->password = Hash::make($request->password);
            $agent->save();

            Common::one_time_message('success', __('Password Updated Successfully'));
            return redirect('agent/profile');
        } else {
            Common::one_time_message('error', __('Your Old Password is Wrong'));
            return redirect('agent/profile');
        }
    }

    public function updateProfileInfo(UpdateProfileRequest $request)
    {
        try {
            executeAgentPostApi("profile", $request);
            Common::one_time_message('success', __('Profile Updated Successfully'));

            return redirect('agent/profile');
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect('agent/profile');
        }

    }

    public function profileImage(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect('agent/profile');
        } else {
            $validator = Validator::make($request->all(),
            [
                'file' => [ new CheckValidFile(getFileExtensions(1), true)],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $fileName = '';
            $agent = Agent::find(Auth::guard('agent')->user()->id);
            $oldPicture = $agent->picture ?? null;
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
                $agent->picture = $fileName;
            }
            $agent->save();
            return $fileName;
        }
    }

    public function searchUser(Request $request)
    {
        $str = $request->term;

        $relatedUser0 = User::where('users.first_name', 'LIKE', '%' . $str . '%')
            ->orWhere('users.last_name', 'LIKE', '%' . $str . '%')
            ->orWhere('users.phone', 'LIKE', '%' . $str . '%')
            ->orWhere('users.email', 'LIKE', '%' . $str . '%')
            ->select('users.id', 'users.email', 'users.agent_id', 'users.phone', 'users.carrierCode', 'users.first_name', 'users.last_name', 'users.status')
            ->get();
        $relatedUser = $relatedUser0->where('status', 'Active');

        $myArr = array();

        if (!empty($relatedUser)) {
            foreach ($relatedUser as $result) {
                $phone = !empty($result->phone) ? ' - '. $result->carrierCode.$result->phone : '';
                $myArr[] = array(
                  "id" => $result->id,
                  "text" => $result->first_name .' '. $result->last_name .' - '. $result->email . $phone
                );
            }
        }

        return $myArr;
    }

    public function getFeesLimit(Request $request)
    {
        $success = executeAgentPostApi('deposit-amount-limit', $request);
        $success['status'] = 200;

        return $success;
    }

    public function fail()
    {
        return view('agent::common.fail');
    }

    public function checkAgentStatus()
    {
        $data['message'] = __('You are suspended to do any kind of transaction!');
        return view('agent::common.check_status', $data);
    }
}
