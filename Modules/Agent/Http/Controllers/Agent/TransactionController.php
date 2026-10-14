<?php

namespace Modules\Agent\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\EmailController;
use App\Http\Helpers\Common;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $helper;
    protected $email;
    protected $revenue;

    public function __construct()
    {
        $this->helper = new Common();
        $this->email = new EmailController();
        $this->revenue = new Transaction();
    }

    public function dashboard()
    {
        try {
            $data = executeAgentApi('dashboard');
            $data['menu'] = 'dashboard';
            $data['title'] = 'Dashboard';
            return view('agent::agent.layouts.dashboard', $data);
        } catch (Exception $e) {
            Common::one_time_message('error', $e->getMessage());
            return redirect()->route('agent.fail');
        }
    }

    public function index(Request $request)
    {
        $data = executeAgentApi('transaction-list', $request->all());

        $data['from'] = isset(request()->from) ? setDateForDb(request()->from) : null;
        $data['to'] = isset(request()->to) ? setDateForDb(request()->to) : null;
        $data['status'] = isset(request()->status) ? request()->status : 'all';
        $data['type'] = isset(request()->type) ? request()->type : 'all';
        $data['currency_id'] = isset(request()->currency_id) ? request()->currency_id : 'all';
        
        return view('agent::agent.transaction.index', $data);
    }

    public function getTransaction(Request $request)
    {
        $data['status'] = 0;
        $transaction = Transaction::with([
            'payment_method:id,name',
            'transaction_type:id,name',
            'currency:id,code,symbol',
            'agent:id,first_name,last_name,email,phone',
            'end_user:id,first_name,last_name,email,formattedPhone',
        ])->find($request->id);

        if ($transaction->count() > 0) {

            $pm = $transaction->payment_method->id == Mts ? settings('name') : $transaction->payment_method->name;

            $fee = abs($transaction->total) - abs($transaction->subtotal);

            $data['html'] = view('agent::agent.agent_dashboard.template.transaction', compact('transaction', 'fee', 'pm'))->render();

            $data['total'] = view('agent::agent.agent_dashboard.template.transaction-total', compact('transaction', 'fee', 'pm'))->render();
        }
        return json_encode($data);
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
        generatePDF('agent::agent.transaction.deposit_pdf', 'agent_cashout_', $data);
    }
}
