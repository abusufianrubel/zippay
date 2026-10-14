<?php

namespace Modules\Agent\Entities;

use Exception;
use App\Models\{Country, 
    Transaction
};
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['business_name', 'business_address', 'first_name', 'last_name', 'email', 'password', 'iso2', 'dial_code', 'phone', 'formatted_phone', 'nid_number', 'nid_photo', 'photo', 'address', 'city', 'state', 'timezone', 'status', 'agent_package_id', 'country_id'];

    /**
     * The directory for storing profile images.
     *
     * @var string
     */
    public static $directory = "Modules/Agent/Resources/assets/images/profile/";

    /**
     * Get the agent's package.
     */
    public function agentPackage()
    {
        return $this->hasOne(AgentPackage::class, 'id', 'agent_package_id');
    }

    /**
     * Get the agent's wallets.
     */
    public function agentWallets()
    {
        return $this->hasMany(AgentWallet::class);
    }

    /**
     * Get the agent's transactions.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Find an agent by ID with wallets.
     *
     * @param int $id
     * @return \App\Models\Agent|null
     */
    public function findByIdWithWallets($id)
    {
        return self::with(['agentWallets', 'agentWallets.currency:id,code,symbol'])->find($id);
    }

    /**
     * Update an agent's data.
     *
     * @param array $data
     * @return \App\Models\Agent
     * @throws Exception
     */
    public function updateAgent(array $data)
    {
        $agent = $this->findAgentById($data['id']);
        if (!$agent) {
            throw new Exception('Agent not found.');
        }
        $this->updateAgentData($agent, $data);
        $this->updateAgentStatus($agent, $data['status']);

        return $agent;
    }

    /**
     * Find an agent by ID.
     *
     * @param int $id
     * @return \App\Models\Agent|null
     */
    private function findAgentById($id)
    {
        return self::find($id);
    }

    /**
     * Update an agent's data.
     *
     * @param \App\Models\Agent $agent
     * @param array $data
     */
    private function updateAgentData($agent, array $data)
    {
        $agent->first_name = $data['first_name'];
        $agent->last_name = $data['last_name'];
        $agent->type = 'Agent';

        if (!empty($data['phone'])) {
            $this->updateAgentPhone($agent, $data);
        } elseif (empty($data['phone']) && empty($agent->phone)) {
            $this->clearAgentPhone($agent);
        }
        
        $agent->save();
    }

    /**
     * Update an agent's phone details.
     *
     * @param \App\Models\Agent $agent
     * @param array $data
     */
    private function updateAgentPhone($agent, array $data)
    {
        $agent->phone = $data['phone'];
        $agent->iso2 = $data['iso2'];
        $agent->dial_code = $data['dial_code'];
        $agent->formatted_phone = $data['formatted_phone'];
    }

    /**
     * Clear an agent's phone details.
     *
     * @param \App\Models\Agent $agent
     */
    private function clearAgentPhone($agent)
    {
        $agent->phone = null;
        $agent->iso2 = null;
        $agent->dial_code = null;
        $agent->formatted_phone = null;
    }

    /**
     * Update an agent's password.
     *
     * @param \App\Models\Agent $agent
     * @param array $data
     */
    private function updateAgentPassword(Agent $agent, array $data)
    {
        if (!is_null($data['password']) && !is_null($data['confirm_password'])) {
            $agent->password = Hash::make($data['password']);
            $agent->save();
        }

        Validator::make(request()->all(), [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed'],
        ])->validate();

        request()->user()->update([
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Update an agent's status.
     *
     * @param \App\Models\Agent $agent
     * @param string $status
     */
    private function updateAgentStatus($agent, $status)
    {
        $agent->status = $status ?: $agent->status;
        $agent->save();
    }

    /**
     * Get the country associated with the agent.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
