<?php

namespace Modules\Agent\Services;

use Exception;
use Modules\Agent\Entities\AgentPackage;

class AgentPackageService
{
    /**
     * createPackage
     *
     * @param  mixed $data
     * @return void
     */
    public function createPackage($data)
    {
        if ($data['is_default'] == 'Yes') {
            AgentPackage::where('is_default', 'Yes')->update(['is_default' => 'No']);
        }
        return AgentPackage::create($data);
    }
    
    /**
     * getAllPackages
     *
     * @return void
     */
    public static function getAllPackages()
    {
        return AgentPackage::all();
    }
    
    /**
     * getPackage
     *
     * @param  mixed $id
     * @return void
     */
    public function getPackage($id)
    {
        return AgentPackage::findOrFail($id);
    }
    
    /**
     * updatePackage
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return void
     */
    public function updatePackage($id, $data)
    {
        if ($data['is_default'] == 'Yes') {
            AgentPackage::where('is_default', 'Yes')->update(['is_default' => 'No']);
        }
        $package = AgentPackage::findOrFail($id);
        if ($package->is_default == 'Yes') throw new Exception(__('The default :x cannot be updated.', ['x' => __('agent package')]));
        $package->update($data);
        return $package;
    }
    
    /**
     * deletePackage
     *
     * @param  mixed $id
     * @return void
     */
    public function deletePackage($id)
    {
        $package = AgentPackage::findOrFail($id);
        if ($package->is_default == 'Yes') throw new Exception(__('The default :x cannot be deleted.', ['x' => __('agent package')]));
        $package->delete();
    }

    public static function getDefaultAgentPackageId()
    {
        return AgentPackage::where('is_default', 'Yes')->value('id');
    }
}
