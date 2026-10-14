<?php

namespace Modules\Agent\Http\Controllers\Admin;

use App\Http\Helpers\Common;
use App\Models\Currency;
use App\Models\FeesLimit;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\TransactionType;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class FeesLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $type = request()->type ?? 'cashin';
        $transactionType = TransactionType::where(['name' => ucfirst($type)])->first();
        $paymentMethod = PaymentMethod::where(['name' => 'Cash'])->first();
        $currencies = Currency::where('type', 'fiat')
            ->with(['fees_limit' => function ($query) use($transactionType, $paymentMethod) {
                $query->where('transaction_type_id', $transactionType->id)
                    ->where('payment_method_id', $paymentMethod->id);
            }])
            ->get();
            
        return view('agent::admin.feeslimits.index', [
            'currencies' => $currencies,
            'preference' => preference('decimal_format_amount', 2),
            'transactionType' => $transactionType,
            'menu' => 'agents',
            'sub_menu' => 'feeslimit',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $paymentMethod = PaymentMethod::where('name', 'Cash')->first();

        foreach ($data['currency_id'] as $value) {
            FeesLimit::updateOrCreate(
                [
                    'transaction_type_id' => $request->transaction_type,
                    'currency_id' => $value,
                    'payment_method_id' => $paymentMethod->id,
                ],
                [
                    'currency_id' => $value,
                    'transaction_type_id' => $request->transaction_type,
                    'payment_method_id' => $paymentMethod->id,
                    'charge_percentage' => $data['charge_percentage'][$value] ?? 0.00,
                    'charge_fixed' => $data['charge_fixed'][$value] ?? 0.00,
                    'min_limit' => ($data['min_limit'][$value] == null) ? 1.00000000 : $data['min_limit'][$value],
                    'max_limit' => $data['max_limit'][$value] ?? null,
                    // FIX: Added isset() wrapper to prevent undefined array key crashes
                    'has_transaction' => (isset($data['default_currency'][$value]) && $data['default_currency'][$value])
                        ? 'Yes'
                        : ($data['has_transaction'][$value] ?? 'No')
                ]
            );
        }

        Common::one_time_message('success', __('The :x has been successfully saved.', ['x' => __('currency settings')]));

        return redirect()->route('admin.agents.feeslimits.index', ['type' => $request->type]);
    }
}