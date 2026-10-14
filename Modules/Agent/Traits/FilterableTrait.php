<?php

namespace Modules\Agent\Traits;

trait FilterableTrait
{
    public static function filterTransactions($from, $to, $currency, $status, $user, $agent, $additionalRelations = [])
    {
        $query = self::query();

        if (!empty($from) && !empty($to)) {
            $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);

        }

        if ($currency !== 'all') {
            $query->where('currency_id', $currency);
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($user) {
            $query->where('user_id', $user);
        }

        if ($agent) {
            $query->where('agent_id', $agent);
        }

        $query->with('user', 'currency', 'agent');

        if (!empty($additionalRelations)) {
            $query->with($additionalRelations);
        }

        return $query;
    }
}