<?php

namespace Modules\Agent\Entities;

use Exception;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentWallet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agent_wallets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agent_id', 'currency_id', 'balance', 'is_default'];

    
    /**
     * Get the currency associated with the wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get the active currency associated with the wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activeCurrency()
    {
        return $this->currency()->where('status', 'Active');
    }

    /**
     * Define a relationship between the AgentWallet and Agent models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * Get the balance of each currency in the wallet.
     *
     * @return array
     */
    public function walletBalance(): array
    {
        $data = $this->leftJoin('currencies', 'currencies.id', '=', 'agent_wallets.currency_id')
            ->select(DB::raw('SUM(agent_wallets.balance) as amount, agent_wallets.currency_id, currencies.type, currencies.code, currencies.symbol'))
            ->groupBy('agent_wallets.currency_id')
            ->get();

        $array_data = [];
        foreach ($data as $row) {
            $array_data[$row->code] = $row->type != 'fiat' ? $row->amount : formatNumber($row->amount);
        }
        return $array_data;
    }

    /**
     * Get available balance of each currency for a specific agent.
     *
     * @param int $agent_id The ID of the agent.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableBalance(int $agent_id): \Illuminate\Support\Collection
    {
        return $this->with(['currency:id,type,code'])
            ->where('agent_id', $agent_id)
            ->orderBy('available_balance', 'ASC')
            ->get(['currency_id', 'is_default', 'available_balance'])
            ->map(function ($agentWallet) {
                $arr['available_balance'] = $agentWallet->currency->type != 'fiat' ? $agentWallet->available_balance : formatNumber($agentWallet->available_balance);
                $arr['is_default'] = $agentWallet->is_default;
                $arr['curr_code'] = $agentWallet->currency->code;
                return $arr;
            });
    }

    /**
     * Get all wallets of a specific agent.
     *
     * @param int $agentId The ID of the agent.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAgentWallet(int $agentId): Collection
    {
        return self::with('currency:id,type,code,symbol,logo')
            ->where('agent_id', $agentId)
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Get wallets of a specific agent with active currency and related fees.
     *
     * @param int $agentId The ID of the agent.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveCurrencyWallets(int $agentId): Collection
    {
        return self::with('activeCurrency:id,code')
            ->where('agent_id', $agentId)
            ->whereHas('activeCurrency', function ($q) {
                $q->whereHas('fees_limit', function ($query) {
                    $query->where(
                        [
                            'transaction_type_id' => Cashin,
                            'payment_method_id' => Cash,
                            'has_transaction' => 'Yes'
                        ]
                    );
                });
            })
            ->get();
    }

    /**
     * Get the balance of a specific currency for a specific agent.
     *
     * @param int $agentId The ID of the agent.
     * @param int $currencyId The ID of the currency.
     *
     * @return float The balance of the currency for the agent.
     *
     * @throws \Exception If the wallet for the currency is not found.
     */
    public static function getBalance(int $agentId, int $currencyId): float
    {
        $wallet = self::where(['agent_id' => $agentId, 'currency_id' => $currencyId])->first();

        if (is_null($wallet)) {
            throw new Exception(__('Wallet for this currency is not found.'));
        }

        return $wallet->balance;
    }

    /**
     * deductAmountFromWallet
     *
     * @param  int $userId
     * @param  int $currencyId
     * @param  float $amount
     * @return void
     */
    public static function deductAmountFromWallet(int $userId, int $currencyId, float $amount): void
    {
        self::where([
            'agent_id' => $userId,
            'currency_id' => $currencyId,
        ])->decrement('balance', $amount);
    }

    /**
     * incrementWalletBalance
     *
     * @param  int $userId
     * @param  int $currencyId
     * @param  float $amount
     * @return void
     */
    public static function incrementWalletBalance(int $userId, int $currencyId, float $amount): void
    {
        self::where([
            'agent_id' => $userId,
            'currency_id' => $currencyId,
        ])->increment('balance', $amount);
    }

    /**
     * Apply a scope to retrieve transactions by agent ID and currency ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The Eloquent query builder.
     * @param int $agentId The ID of the agent.
     * @param int $currencyId The ID of the currency.
     *
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder.
     */
    public function scopeByAgentAndCurrency(Builder $query, int $agentId, int $currencyId): Builder
    {
        return $query->where('agent_id', $agentId)
            ->where('currency_id', $currencyId);
    }
}
