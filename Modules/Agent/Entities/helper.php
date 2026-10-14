<?php

use App\Models\{
    User,
    PaymentMethod
};
use Modules\Agent\Entities\Agent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Agent\Entities\AgentWallet;

if (!function_exists('checkAgentStatus')) {
    function checkAgentStatus()
    {
        $id = Auth::guard('agent')->user()->id;
        return Agent::findOrFail($id);
    }
}

if (!function_exists('getAgentPackage')) {
    function getAgentPackage($id)
    {
        $agent = Agent::with('agentPackage')->findOrFail($id);
        return $agent->agentPackage;
    }
}

if (!function_exists(('getAgentCommission'))) {
    function getAgentCommission($agent, $amount)
    {
        $agentPackage = getAgentPackage($agent);
        return $amount * ($agentPackage->commission / 100);
    }
}

if (!function_exists('checkAgentBalance')) {
    function checkAgentBalance($amount, $id)
    {
        $agent = AgentWallet::where(['agent_id' => $id, 'currency_id' => $amount->currency_id])->first();
        if ($amount->amount <= $agent->balance) {
            return true;
        }
        return false;
    }
}

if (!function_exists('getFullName')) {
    function getFullName($agent): string
    {
        return isset($agent->first_name) && isset($agent->last_name) ? 
                $agent->first_name . ' ' . $agent->last_name : '';
    }
}


if (!function_exists('getAccessToken')) {
    function getAccessToken($agent)
    {
        return $agent->createToken(getFullName($agent))->accessToken;
    }
}


if (!function_exists('executeAgentApi')) {
    function executeAgentApi($url, $arr = [])
    {
        $arr['lang'] = session('dflt_lang'); 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . getAgentAccessToken(),
        ])->get(setUrl($url, $arr));

        $apiData = $response->json();

        if (
            isset($apiData['response']['status'])
            && $apiData['response']['status']['code'] == 422
        ) {
            throw new Exception($apiData['response']['message']);
        }

        if ($apiData['response']['status']['code'] == 401) {
            session()->forget('agentAccessToken');
            throw new Exception($apiData['response']['status']['message']);
        }

        return $apiData['response']['records'] ?? null;
    }
}


if (!function_exists('executeAgentPostApi')) {
    function executeAgentPostApi($url, $data)
    {
        $data['lang'] = session('dflt_lang'); 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . getAgentAccessToken(),
        ])->post(setUrl($url), $data);

        $apiData = $response->json();

        if (
            isset($apiData['response']['status'])
            && $apiData['response']['status']['code'] == 422
        ) {
            throw new Exception($apiData['response']['status']['message']);
        }

        return $apiData['response']['records'] ?? null;
    }
}

if (!function_exists('executeNoAuthAgentPostApi')) {
    function executeNoAuthAgentPostApi($url, $data)
    {
        $response = Http::post(setUrl($url), $data);
        $apiData = $response->json();

        if (
            isset($apiData['response']['status'])
            && $apiData['response']['status']['code'] == 422
        ) {
            throw new Exception($apiData['response']['status']['message']);
        }

        return $apiData['response']['records'] ?? null;
    }
}


if (!function_exists('agentAccessToken')) {
    function agentAccessToken()
    {
        return  getAccessToken(auth('agent')->user());
    }
}

if (!function_exists('getAgentAccessToken')) {
    function getAgentAccessToken()
    {
        $agent =  auth('agent')->user();
        $accessToken = DB::table('oauth_access_tokens')
            ->where(['user_id' =>  $agent->id, 'name' => getFullName($agent)])->first();

        if (session()->has('agentAccessToken') && $accessToken ) {
            return session('agentAccessToken');
        }

        $token = agentAccessToken();
        session(['agentAccessToken' => $token]);
        return $token;
    }
}

if (!function_exists('setUrl')) {
    function setUrl($url, $par = [])
    {
        if (empty($par)) {
            return url('api/v2/agent',  $url);
        }
        return url('api/v2/agent/' . $url . '?' . http_build_query($par));
    }
}

if (!function_exists('getNameById')) {
    function getNameById($id)
    {
        return PaymentMethod::find($id);
    }
}

if (!function_exists('getPaymentMethodViaName')) {

    function getPaymentMethodViaName($name)
    {
        return PaymentMethod::where(['name' => $name])->active()->first();
    }
}

if (!function_exists('getAgentId')) {

    function getAgentId()
    {
        return Auth::guard('agent')->id();
    }
}

if (!function_exists('totalFeesWithoutAgentFees')) {
    function totalFeesWithoutAgentFees($transaction): float
    {
        $fees = 0;
        if ($transaction->charge_percentage != 0) {
            $fees = $fees + $transaction->charge_percentage;
        }

        if ($transaction->charge_fixed != 0) {
            $fees = $fees + $transaction->charge_fixed;
        }

        return $fees;
    }
}

if (!function_exists('totalFees')) {
    function totalFees($transaction): float
    {
        $fees = 0;
        if ($transaction->charge_percentage != 0) {
            $fees = $fees + $transaction->charge_percentage;
        }

        if ($transaction->charge_fixed != 0) {
            $fees = $fees + $transaction->charge_fixed;
        }

        if (moduleExists('Agent') && $transaction->agent_percentage != 0) {
            $fees = $fees + $transaction->agent_percentage;
        }

        return $fees;
    }
}

if (!function_exists('totalAmount')) {
    function totalAmount($transaction, $amount): float
    {
        return totalFees($transaction) + $amount;
    }
}

if (!function_exists('agentDateFormat')) {
    function agentDateFormat($value)
    {
        $defaultTimezone = preference('dflt_timezone');

        $agent = auth('agent-v2')->user() ?? auth()->guard('agent')->user();

        if (isset($agent->timezone)) {
            $defaultTimezone = $agent->timezone;
        }

        $today = new DateTime($value, new DateTimeZone(config('app.timezone')));
        $today->setTimezone(new DateTimeZone($defaultTimezone));
        $value = $today->format('Y-m-d H:i:s');

        $preferenceData = \App\Models\Preference::where(['category' => 'preference'])
                            ->whereIn('field', ['date_format_type', 'date_sepa'])
                            ->get(['field', 'value'])->toArray();               
        $preferenceData = App\Http\Helpers\Common::key_value('field', 'value', $preferenceData);
        $preference     = $preferenceData['date_format_type'];
        $separator      = $preferenceData['date_sepa'];

        $data   = str_replace(['/', '.', ' ', '-'], $separator, $preference);
        $data   = explode($separator, $data);
        [$first, $second, $third] = $data;

        $dateInfo = str_replace(['/', '.', ' ', '-'], $separator, $value);
        $datas    = explode($separator, $dateInfo);
        [$year, $month, $day] = $datas;

        $dateObj   = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');

        $toHoursMin = \Carbon\Carbon::createFromTimeStamp(strtotime($value))->format(' g:i A');
        if ($first == 'yyyy' && $second == 'mm' && $third == 'dd') {
            $value = $year . $separator . $month . $separator . $day . $toHoursMin;
        } elseif ($first == 'dd' && $second == 'mm' && $third == 'yyyy') {
            $value = $day . $separator . $month . $separator . $year . $toHoursMin;
        } elseif ($first == 'mm' && $second == 'dd' && $third == 'yyyy') {
            $value = $month . $separator . $day . $separator . $year . $toHoursMin;
        } elseif ($first == 'dd' && $second == 'M' && $third == 'yyyy') {
            $value = $day . $separator . $monthName . $separator . $year . $toHoursMin;
        } elseif ($first == 'yyyy' && $second == 'M' && $third == 'dd') {
            $value = $year . $separator . $monthName . $separator . $day . $toHoursMin;
        }
        return $value;
    }
}

if (!function_exists('getCountryByIP')) {
    /**
     * Get the country based on the client's IP address using the ipinfo.io API.
     *
     * @return string|null The ISO 3166-1 alpha-2 country code or null if not found.
     */
    function getCountryByIP()
    {
        $ipAddress = request()->ip();

        $response = Http::get("https://ipinfo.io/{$ipAddress}/json");

        $data = $response->json();

        return $data['country'] ?? null;
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($inputDateTime, $userId = null)
    {
        if (!empty($userId)) {
            $user = User::with('user_detail:user_id,timezone')->where(['id' => $userId])->first(['id']);
        } else {
            if (!empty(auth()->user()->id)) {
                $user = User::with('user_detail:user_id,timezone')->where(['id' => auth()->user()->id])->first(['id']);
            } else {
                $user = null;
            }
        }

        $timezone = 'UTC';

        if (!empty($user) && !empty($user->user_detail)) {
            $timezone = $user->user_detail->timezone;
        } elseif (!empty($userId) && empty($user)) {
            $timezone = preference('dflt_timezone');
        }

        date_default_timezone_set($timezone);
        $dateTime = new DateTime($inputDateTime);
        return $dateTime->format('d-m-Y g:i A');
    }
}

if (!function_exists('fullName')) {
    function fullName($agent)
    {
        return $agent->first_name . ' ' . $agent->last_name;
    }
}

if (!function_exists('getImagePath')) {
    /**
    * this function is used for agent transaction image fetch
    * @param int $typeId
    * @param string $paymentMethodName
    */

    function getImagePath($typeTd = null, $paymentMethodName = null) {
        switch ($typeTd) {
            case Deposit:
                $imagePath = image(null,  $paymentMethodName);
                break;

            case Cashin:
                $imagePath = asset('Modules/Agent/Resources/assets/images/cashin.png');
                break;

            case Cashout:
                $imagePath = asset('Modules/Agent/Resources/assets/images/cashout.png');
                break;

            default:
                $imagePath = image(null,  null);
                break;
        }

        return $imagePath;
    }
}

if (!function_exists('getAgentDefaultPackageId')) {
    /**
     * Get the ID of the default agent package.
     *
     * @return int The ID of the default agent package.
     */
    function getAgentDefaultPackageId()
    {
        return \Modules\Agent\Entities\AgentPackage::where('is_default', 'Yes')->value('id');
    }
}

if (!function_exists('getAgentIdByEmail')) {
    /**
     * Get the ID of the agent with the given email address.
     *
     * @param string $email
     * @return int The ID of the agent.
     */
    function getAgentIdByEmail($email)
    {
        return \Modules\Agent\Entities\Agent::where('email', $email)->value('id');
    }
}

