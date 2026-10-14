<?php

namespace Modules\Agent\Http\Controllers\Admin;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Modules\Agent\Entities\Cashin;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Agent\Exports\CashinsExport;
use Modules\Agent\DataTables\AgentCashInDataTable;
use Modules\Agent\Entities\AgentWallet;

class AgentCashInController extends Controller
{
    protected $cashin;

    public function __construct()
    {
        $this->cashin = new Cashin();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AgentCashInDataTable $dataTable)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'cashin';

        $data['from']     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $data['to']       = isset(request()->to ) ? setDateForDb(request()->to) : null;
        $data['currency'] = isset(request()->currency) ? request()->currency : 'all';
        $data['status']   = isset(request()->status) ? request()->status : 'all';
        $data['user']     = isset(request()->user_id) ? request()->user_id : null;
        $data['getName']  = $this->cashin->getCashinsUsersName($data['user']);

        $data['transactionStatus']     = $this->cashin->select('status')->groupBy('status')->get();
        $data['transactionCurrencies'] = $this->cashin->with('currency:id,code')->select('currency_id')->groupBy('currency_id')->get();

        return $dataTable->render('agent::admin.cashin.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashin $cashin)
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'cashin';
        $data['cashin'] = $cashin;
        $data['transaction'] = $cashin->transaction;

        return view('agent::admin.cashin.edit', $data);
    }

    public function update(Request $request)
    {
        if ($request->transaction_type == 'Cashin') {
            if ($request->status == 'Success') {
                if ($request->transaction_status == 'Success') {
                    Common::one_time_message('success', __('The :x status is already :y.', ['x' => __('Cashin'), 'y' => __('successful')]));
                    return redirect()->route('admin.agents.cashin.index');
                } elseif ($request->transaction_status == 'Blocked') {
                    $cashin = Cashin::find($request->id);
                    $cashin->status = $request->status;
                    $cashin->save();

                    Transaction::where([
                        'transaction_reference_id' => $request->transaction_reference_id,
                        'transaction_type_id'      => $request->transaction_type_id,
                    ])->update([
                        'status' => $request->status,
                    ]);

                    Wallet::deductAmountFromWallet($request->user_id, $request->currency_id, $request->amount);
                    AgentWallet::incrementWalletBalance($request->agent_id, $request->currency_id, $request->amount);

                    Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('Cashin')]));
                    return redirect()->route('admin.agents.cashin.index');
                }
            } elseif ($request->status == 'Blocked') {
                if ($request->transaction_status == 'Blocked') {
                    Common::one_time_message('success', __('The :x status is already :y.', ['x' => __('Cashin'), 'y' => __('blocked')]));
                    return redirect()->route('admin.agents.cashin.index');
                } elseif ($request->transaction_status == 'Success') {
                    $cashin = Cashin::find($request->id);
                    $cashin->status = $request->status;
                    $cashin->save();

                    Transaction::where([
                        'transaction_reference_id' => $request->transaction_reference_id,
                        'transaction_type_id'      => $request->transaction_type_id,
                    ])->update([
                        'status' => $request->status,
                    ]);

                    Wallet::incrementWalletBalance($request->user_id, $request->currency_id, $request->amount);
                    AgentWallet::deductAmountFromWallet($request->agent_id, $request->currency_id, $request->amount);

                    Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('Cashin')]));
                    return redirect()->route('admin.agents.cashin.index');
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function printPdf()
    {
        $from = !empty(request()->startfrom) ? setDateForDb(request()->startfrom) : null;
        $to = !empty(request()->endto) ? setDateForDb(request()->endto) : null;
        $currency = isset(request()->currency) ? request()->currency : null;
        $status = isset(request()->status) ? request()->status : null;
        $user = isset(request()->user_id) ? request()->user_id : null;
        $agent = isset(request()->agent_id) ? request()->agent_id : null;

        $data['cashins'] = Cashin::filterTransactions($from, $to, $currency, $status, $user, $agent)->orderBy('id', 'desc')->get();
        $data['date_range'] = (isset($from) && isset($to)) ? $from . ' To ' . $to : 'N/A';

        generatePDF('agent::admin.cashin.pdf', 'cashin_transactions_', $data);
    }

    public function cashinSearchUser(Request $request)
    {
        $search = $request->search;
        $user = $this->cashin->getCashinsUsersResponse($search);

        $res = [
            'status' => 'fail',
        ];
        if (count($user) > 0)
        {
            $res = [
                'status' => 'success',
                'data'   => $user,
            ];
        }

        return json_encode($res);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function printCsv()
    {
        return Excel::download(new CashinsExport(), 'cashin_transactions_'. time() .'.csv');
    }
}
