<?php

namespace Modules\Agent\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentPackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'commission', 'is_default'];

    /**
     * Get the agents associated with the agent package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany(Agent::class, 'agent_package_id');
    }

    /**
     * Delete the agent package.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $this->ensureNoAssignedAgents();

        return parent::delete();
    }

    /**
     * Ensure that no agents are assigned to this agent package before deleting.
     *
     * @return void
     * @throws \Exception
     */
    private function ensureNoAssignedAgents()
    {
        if ($this->agents()->exists()) {
            throw new Exception(__('Cannot delete. Agents are assigned to this agent package.'));
        }
    }
}

