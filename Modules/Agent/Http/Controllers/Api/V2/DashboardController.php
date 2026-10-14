<?php

namespace Modules\Agent\Http\Controllers\Api\V2;

use Exception;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Modules\Agent\Entities\AgentWallet;
use Modules\Agent\Services\AgentService;
use Modules\Agent\Transformers\AgentWalletResource;
use Modules\Agent\Transformers\TransactionResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }
    
    public function dashboard(Request $request)
    {
        try {
            if (auth('agent-v2')->user()->type == 'Agent') {
                $transactions = $this->agentService->getTransactions($request->all());
            }
            
            $data['transactions'] = TransactionResource::collection($transactions);
            
            $wallets = AgentWallet::getAgentWallet(auth('agent-v2')->user()->id);
            
            $data['wallets'] = AgentWalletResource::collection($wallets);
            
            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->unprocessableResponse([], __("Failed to process the request."));
        }
    }
}
