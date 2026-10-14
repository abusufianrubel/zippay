<?php

namespace Modules\Agent\Services;

use Modules\Agent\Entities\AgentWallet;

class WalletService
{
    /**
     * The AgentWallet model instance.
     *
     * @var \Modules\Agent\Entities\AgentWallet
     */
    private $walletModel;

    /**
     * Create a new WalletService instance.
     *
     * @param  \Modules\Agent\Entities\AgentWallet  $walletModel
     * @return void
     */
    public function __construct(AgentWallet $walletModel)
    {
        $this->walletModel = $walletModel;
    }

    /**
     * Create the default wallet for the agent.
     *
     * @param  int  $agentId
     * @return void
     */
    public function createAgentDefaultWallet(int $agentId)
    {
        $this->createWallet($agentId, settings('default_currency'), true);
    }

    /**
     * Create the allowed wallets for the agent.
     *
     * @param  int  $agentId
     * @return void
     */
    public function createAgentAllowedWallets(int $agentId)
    {
        $currencies = explode(',', settings('allowed_wallets'));
        
        foreach ($currencies as $currencyId) {
            $this->createWallet($agentId, $currencyId, false);
        }
    }

    /**
     * Change the default wallet for the agent.
     *
     * @param  int  $id
     * @param  int  $agentId
     * @return void
     */
    public function changeDefaultWallet(int $id, int $agentId)
    {
        $reqWallet = $this->walletModel->find($id);

        if ($reqWallet && $reqWallet->is_default != 'Yes') {
            $this->makeAllNonDefaultWallets($agentId);
            $reqWallet->update(['is_default' => 'Yes']);
        }
    }

    /**
     * Create a new wallet.
     *
     * @param  int  $agentId
     * @param  int  $currencyId
     * @param  bool  $isDefault
     * @return void
     */
    private function createWallet(int $agentId, int $currencyId, bool $isDefault)
    {
        $this->walletModel->create([
            'agent_id' => $agentId,
            'currency_id' => $currencyId,
            'is_default' => $isDefault ? 'Yes' : 'No',
        ]);
    }

    /**
     * Make all wallets of the agent non-default.
     *
     * @param  int  $agentId
     * @return void
     */
    private function makeAllNonDefaultWallets(int $agentId)
    {
        $this->walletModel->where('agent_id', $agentId)
            ->where('is_default', 'Yes')
            ->update(['is_default' => 'No']);
    }
}