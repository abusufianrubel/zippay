<?php

namespace Modules\Agent\Http\Controllers\Agent;

use App\Http\Controllers\Users\EmailController;
use Modules\Agent\Entities\Agent;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use App\Models\{
    Currency,
    Transaction,
    UserDetail,
    User
};
use Exception;
use Modules\Agent\Http\Requests\CashoutRequest;

class AgentCashOutController extends Controller
{
    /**
     * Instance of the Agent model.
     *
     * @var Agent
     */
    protected $agent;

    /**
     * Instance of the EmailController.
     *
     * @var EmailController
     */
    protected $email;

    /**
     * CashoutController constructor.
     *
     * Initializes the $agent and $email properties.
     */
    public function __construct()
    {
        $this->agent = new Agent();
        $this->email = new EmailController();
    }

    /**
     * Display the cash-out creation view.
     *
     * Sets the action session, prepares data for the view, and renders the view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Set the action session for the current controller
        setActionSession();

        // Prepare data for the view
        $data['menu'] = 'cashout';
        $data['content_title'] = 'Cashout';

        // Render the cash-out creation view with the prepared data
        return view('agent::agent.cash-out.create', $data);
    }

    /**
     * Confirm the cash-out request by performing various actions such as
     * checking user balance, sending withdrawal OTP, and preparing data for confirmation.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function confirm(CashoutRequest $request)
    {
        try {
            // Retrieve the user based on the provided email
            $user = User::where('email', $request->user)->first();
            
            // Add user_id to the request data
            $request['user_id'] = $user->id;

            // Execute Agent Post API to check user balance
            $data['transInfo'] = executeAgentPostApi('user-balance-check', $request);

            // Execute Agent Post API to send withdrawal OTP
            $data['otpInfo'] = executeAgentPostApi('withdrawal-otp-send', $request);

            // Retrieve currency symbol based on the currency ID
            $currency_id = $request->currency_id;
            $data['currency'] = Currency::where(['id' => $currency_id])->first();
            $request['currSymbol'] = $data['currency']->symbol;

            // Store transaction information in the session
            session(['transInfo' => $request->all()]);

            // Prepare data for the confirmation view
            // $data['transInfo'] = $request->all();
            $data['user'] = $user;
            $data['paymentMethod'] = Cash;
            // Return the confirmation view with the prepared data
            return view('agent::agent.cash-out.confirm', $data);
        } catch (\Exception $e) {
            // Handle exceptions by displaying an error message and redirecting to the cashout creation page
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent.cashout.create');
        }
    }
    
    /**
     * getCurrencyList
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrencyList(Request $request)
    {
        try {
            $response = executeAgentPostApi('withdrawal-currency-list', $request);
            return response()->json([
                'currencyList' => $response,
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Display the success page after processing a withdrawal confirmation.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function success(Request $request)
    {
        try {
            // Execute Agent Post API to confirm withdrawal
            $response = executeAgentPostApi('withdrawal-confirm', $request);

            setPaymentData($response);
        
            return redirect()->route('agent.cashout.success_url');

        } catch (Exception $e) {
            // Handle exceptions by displaying an error message and redirecting to the cashout creation page
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent.cashout.create');
        }
    }

    public function successUrl()
    {
        try {
            $data = getPaymentData();

            if (empty($data)) {
                return redirect()->route('agent.cashout.create');
            }

            getPaymentData('forget');

            // Render the success view with the API response data
            return view('agent::agent.cash-out.success', $data);
        } catch (Exception $th) {
            Common::one_time_message('error', $th->getMessage());
            return redirect()->route('agent.cashout.create');
        }
    }
    
    /**
     * verifyOtp
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        $user_details = UserDetail::find($request->user_id)->cashout_verification_code;
        $cashout_verification = $request->verification_code;

        if ($user_details == $cashout_verification) {
            $success['status'] = 200;
        } else {
            $success['status'] = 201;
        }

        return response()->json(['success' => $success]);
    }
    
    /**
     * Manage fees by checking the user balance through an Agent Post API.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function manageFees(Request $request)
    {
        try {
            // Execute Agent Post API to check user balance
            $response = executeAgentPostApi('user-balance-check', $request);
            return response()->json([
                'success' => $response,
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Manage fees by checking the user balance through an Agent Post API.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {
        try {
            // Execute Agent Post API to check user balance
            executeAgentPostApi('withdrawal-otp-send', $request);
            return response()->json([
                'message' => __('OTP sent successfully.'),
                'status' => 200,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generate and print a PDF for a specific transaction.
     *
     * @param  int $trans_id The ID of the transaction to print the PDF for.
     * @return void
     */
    public function printPdf($trans_id)
    {
        // Retrieve transaction details based on the provided transaction ID
        $data['transactionDetails'] = Transaction::where(['id' => $trans_id])->first();

        // Generate and print the PDF using a custom function
        generatePDF('agent::agent.cash-out.pdf', 'agent_cashout_', $data);
    }
}
