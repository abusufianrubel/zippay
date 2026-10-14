<?php

namespace Modules\Agent\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Agent\Exports\AgentRevenuesExport;
use Modules\Agent\Services\AgentPaymentService;
use Modules\Agent\DataTables\AgentRevenuesDataTable;

class AgentRevenueController extends Controller
{
    protected $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index(AgentRevenuesDataTable $dataTable)
    {
        $revenueTransactionTypes = [Cashin, Cashout];

        $data = $this->prepareData();

        $getRevenuesListForCurrencyIfo = $this->getAgentRevenuesList(
            $data['from'], $data['to'], $data['currency'], $data['type'], $data['agent']
        );

        $data['currencyInfo'] = $this->calculateCurrencyInfo($getRevenuesListForCurrencyIfo);

        $data['revenues_currency'] = Transaction::where('agent_percentage', '>', 0)
            ->where('status', 'Success')
            ->whereIn('transaction_type_id', $revenueTransactionTypes)
            ->groupBy('currency_id')
            ->select('currency_id')
            ->distinct()
            ->get();
        
        $data['revenues_type'] = Transaction::where('agent_percentage', '>', 0)
            ->where('status', 'Success')
            ->whereIn('transaction_type_id', $revenueTransactionTypes)
            ->groupBy('transaction_type_id')
            ->select('transaction_type_id')
            ->distinct()
            ->get();

        return $dataTable->render('agent::admin.revenues.index', $data);
    }

    private function prepareData()
    {
        $data['menu'] = 'agents';
        $data['sub_menu'] = 'revenues';
        $data['from'] = isset(request()->from) ? setDateForDb(request()->from) : null;
        $data['to'] = isset(request()->to) ? setDateForDb(request()->to) : null;
        $data['currency'] = isset(request()->currency) ? request()->currency : 'all';
        $data['type'] = isset(request()->type) ? request()->type : 'all';
        $data['agent'] = isset(request()->user_id) ? request()->user_id : null;

        if (!empty($data['agent'])) {
            $data['getName'] = $this->transaction->getTransactionsUsersAgentsName($data['agent'], null);
        }

        return $data;
    }

    private function getAgentRevenuesList($from, $to, $currency, $type, $agent)
    {
        return (new AgentPaymentService())->getAgentRevenuesList(
            $from, $to, $currency, $type, $agent
        )->orderBy('transactions.id', 'desc')->get();
    }

    private function calculateCurrencyInfo($revenuesList)
    {
        $currencyInfo = [];

        foreach ($revenuesList as $value) {
            if (isset($value->currency->code) && !in_array($value->currency->code, array_keys($currencyInfo))) {
                $currencyInfo[$value->currency->code]['revenue'] = 0;
                $currencyInfo[$value->currency->code]['currency_id'] = $value->currency->id;
            }
            $currencyInfo[$value->currency->code]['revenue'] += $value->agent_percentage;
        }

        return $currencyInfo;
    }

    public function printCsv()
    {
        return Excel::download(new AgentRevenuesExport(), 'agent_revenues_list_' . time() . '.csv');
    }

    public function printPdf()
    {
        $from = isset(request()->startfrom) && !empty(request()->startfrom) ? setDateForDb(request()->startfrom) : null;
        $to = isset(request()->endto) && !empty(request()->endto) ? setDateForDb(request()->endto) : null;
        $type = isset(request()->type) ? request()->type : null;
        $currency = isset(request()->currency) ? request()->currency : null;
        $agent = isset(request()->user_id) ? request()->user_id : null;

        $data['revenues'] = (new AgentPaymentService())->getAgentRevenuesList(
            $from, $to, $currency, $type, $agent
        )->orderBy('transactions.id', 'desc')->get();
        
        if (isset($from) && isset($to)) {
            $data['date_range'] = $from. ' To ' . $to;
        } else {
            $data['date_range'] = 'N/A';
        }

        generatePDF('agent::admin.revenues.pdf', 'agent_revenues_list_', $data);
    }
}
