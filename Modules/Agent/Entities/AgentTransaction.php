<?php

namespace Modules\Agent\Entities;

class AgentTransaction
{
    /**
     * The default relations to eager load.
     */
    private array $agentRelation = ['cashin', 'cashout'];

    /**
     * Additional transaction relations.
     */
    private array $relations = [];

    /**
     * AgentTransaction constructor.
     *
     * @param array $transactionRelations Additional transaction relations to load.
     */
    public function __construct(private array $transactionRelations = [])
    {
        $this->relations = array_merge($this->agentRelation, $this->transactionRelations);
    }

    /**
     * Get the transaction details.
     *
     * @param int $id The ID of the transaction.
     *
     * @return array Transaction details.
     */
    public function getTransactionDetails($id): array
    {
        $data['menu'] = 'transaction';
        $data['sub_menu'] = 'transactions';

        $data['transaction'] = $this->getTransaction($id);

        return $data;
    }

    /**
     * Get the transaction with eager loaded relations.
     *
     * @param int $id The ID of the transaction.
     *
     * @return \App\Models\Transaction|null Transaction instance, or null if not found.
     */
    public function getTransaction($id): ?\App\Models\Transaction
    {
        return \App\Models\Transaction::with($this->relations)->find($id);
    }
}

