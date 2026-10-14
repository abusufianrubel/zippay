<?php

namespace Modules\Agent\Services;

use Exception;
use App\Models\Transaction;
use Modules\Agent\Entities\{Agent, 
    AgentWallet
};
use Illuminate\Support\Facades\Hash;

class AgentService
{
    /**
     * Get all agents.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAgents()
    {
        return Agent::all();
    }

    /**
     * Create a new agent.
     *
     * @param  array  $data
     * @return \Modules\Agent\Entities\Agent
     */
    public function createAgent(array $data)
    {
        $data = $this->uploadImageIfSet($data, 'photo', 'Modules/Agent/Resources/assets/images/profile', 'photo');

        $data['password'] = Hash::make($data['password']);
        $data['timezone'] = $data['timezone'] ?? preference('dflt_timezone');

        return Agent::create($data);
    }

    /**
     * Upload an image if set in the data.
     *
     * @param  array  $data
     * @param  string  $imageKey
     * @param  string  $path
     * @param  string  $dataKey
     * @return array
     *
     * @throws \Exception
     */
    private function uploadImageIfSet(array $data, string $imageKey, string $path, string $dataKey): array
    {
        if (isset($data[$imageKey])) {
            $image = $data[$imageKey];
            $response = uploadImage($image, base_path($path));

            if (!$response['status']) {
                throw new Exception(__('Upload ' . $imageKey . ' image failed'));
            }

            $data[$dataKey] = $response['file_name'];
        }

        return $data;
    }

    /**
     * Format the phone number.
     *
     * @param  string|null  $carrierCode
     * @param  string|null  $phone
     * @return string|null
     */
    public function formatPhone($carrierCode, $phone)
    {
        if (!empty($phone) && !empty($carrierCode)) {
            return '+' . $carrierCode . $phone;
        }

        return null;
    }

    /**
     * Get the agent status from data.
     *
     * @param  array  $data
     * @return string
     */
    private function getAgentStatus($data)
    {
        return $data['status'] ?? 'Active';
    }

    /**
     * Hash and set the password from data.
     *
     * @param  array  $data
     * @return string|null
     */
    private function hashAndSetPassword($data)
    {
        if (isset($data['password']) && !is_null($data['password']) && !is_null($data['password_confirmation'])) {
            return Hash::make($data['password']);
        } else {
            return null;
        }
    }

    /**
     * Get an agent by ID.
     *
     * @param  int  $id
     * @return \Modules\Agent\Entities\Agent
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getAgentById($id)
    {
        return Agent::findOrFail($id);
    }

    /**
     * Update an existing agent.
     *
     * @param  int  $id
     * @param  array  $data
     * @return \Modules\Agent\Entities\Agent
     */
    public function updateAgent($id, array $data)
    {
        $agent = $this->getAgentById($id);
        $dialCode = $data['dial_code'] ?? $agent['dial_code'];

        $agent->update([
            'first_name' => $data['first_name'] ?? $agent['first_name'],
            'last_name' => $data['last_name'] ?? $agent['last_name'],
            'email' => $data['email'] ?? $agent['email'],
            'iso2' => $data['iso2'] ?? $agent['iso2'],
            'dial_code' => $dialCode,
            'phone' => preg_replace("/[\s-]+/", "", $data['phone']) ?? $agent['phone'],
            'formatted_phone' => $this->formatPhone($dialCode, preg_replace("/[\s-]+/", "", $data['phone'])) ?? $agent['formatted_phone'],
            'password' => $this->hashAndSetPassword($data) ?: $agent['password'],
            'type' => 'Agent',
            'address' => $data['address'] ?? $agent['address'],
            'state' => $data['state'] ?? $agent['state'],
            'city' => $data['city'] ?? $agent['city'],
            'agent_package_id' => $data['agent_package_id'] ?? $agent['agent_package_id'],
            'country_id' => $data['country_id'] ?? $agent['country_id'],
            'timezone' => $data['timezone'] ?? $agent['timezone'],
            'status' => $this->getAgentStatus($data) ?? $agent['status'],
            'business_name' => $data['business_name'] ?? $agent['business_name'],
        ]);

        if (isset($data['default_wallet'])) {
            $this->changeAgentDefaultWallet($agent['id'], $data['default_wallet']);
        }

        return $agent;
    }

    /**
     * Delete an agent.
     *
     * @param  int  $id
     * @return void
     *
     * @throws \Exception
     */
    public function deleteAgent($id)
    {
        $agent = Agent::findOrFail($id);

        if ($agent->transactions->isNotEmpty()) {
            $agent->status = "Inactive";
            $agent->save();
            throw new Exception(__('Cannot delete agent with existing transactions'));
        }

        $agent->delete();
    }

    /**
     * Check if a phone number is available for an agent.
     *
     * @param  string  $phone
     * @param  string  $carrierCode
     * @param  int|null  $agentId
     * @return bool
     */
    public function phoneNumberIsAvailable($phone, $carrierCode, $agentId = null)
    {
        $query = Agent::where(['phone' => $phone, 'dial_code' => $carrierCode]);
        if (isset($agentId) && !empty($agentId)) {
            $query->where('id', '!=', $agentId);
        }

        return !$query->exists();
    }

    /**
     * Check if an email already exists for an agent.
     *
     * @param  string  $email
     * @param  int|null  $agentId
     * @return bool
     */
    public function emailExists($email, $agentId = null)
    {
        $query = Agent::where(['email' => $email]);
        if (isset($agentId) && !empty($agentId)) {
            $query->where('id', '!=', $agentId);
        }

        return $query->exists();
    }

    public function agentDashboardTransaction($type = 'allTransactions', $offset = 0, $limit = 10, $order = 'desc')
    {
        if ('allTransactions' == $type) {
            $type = (new Transaction)::$transactionTypes;
        }

        return Transaction::where(['agent_id' => auth('agent-v2')->user()->id])
            ->whereIn('transaction_type_id', $type)
            ->orderBy('id', $order)
            ->offset($offset)->limit($limit)->get();
    }

    /**
     * Get wallets of an agent.
     *
     * @param  int  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAgentWallets($id, $columns = ['*'])
    {
        return AgentWallet::where('agent_id', $id)->orderBy('id', 'desc')->get($columns);
    }

    /**
     * Get transactions of an agent.
     *
     * @param  array  $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTransactions($filters)
    {
        $agentId = auth('agent-v2')->user()->id;

        $query = Transaction::where('agent_id', $agentId)
            ->whereIn('transaction_type_id', [Cashin, Cashout, Deposit]);

        // Apply filters
        if (isset($filters['currency_id'])) {
            $query->where('currency_id', $filters['currency_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['transaction_type_id'])) {
            $query->whereIn('transaction_type_id', $filters['transaction_type_id']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        // Paginate the results
        $perPage = isset($filters['per_page']) ? $filters['per_page'] : 10;
        
        return $query->latest()->paginate($perPage);
    }

    public function changeAgentDefaultWallet($agentId, $currencyId)
    {

        if (!empty($currencyId) || !is_null($currencyId)) {
            $defaultWallet = AgentWallet::where(['agent_id' => $agentId, 'is_default' => 'Yes'])
                            ->first(['id', 'is_default', 'currency_id']);

            $isWalletExist = AgentWallet::where(
                [
                    'currency_id' => $currencyId, 
                    'agent_id' => $agentId
                ]
            )->exists();

            if (!$isWalletExist) {
                throw new Exception(__('Wallets not available.'));
            }

            if ($defaultWallet->currency_id != $currencyId) {
                $defaultWallet->is_default = 'No';
                $defaultWallet->save();
                AgentWallet::where(
                    [
                        'agent_id' => $agentId, 
                        'currency_id' => $currencyId
                    ]
                )->update(['is_default' => 'Yes']);
            }
            
        }

    }
}