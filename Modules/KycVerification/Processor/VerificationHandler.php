<?php

namespace Modules\KycVerification\Processor;

use App\Facade\VerificationProviderManager;
use Modules\KycVerification\Contract\VerificationContract;

class VerificationHandler
{
    /**
     * Assigns the verification provider based on the current settings.
     *
     * @return void
     * @throws \Exception if the verification processor is not found.
     */
    public static function assignVerificationProvider()
    {
        // Retrieve the current KYC provider setting
        $providerSetting = settings('kyc_provider');

        // Extract a clean string representation for processing if an array is returned
        $provider = is_array($providerSetting) 
            ? ($providerSetting['alias'] ?? $providerSetting['name'] ?? 'manual') 
            : (!empty($providerSetting) ? $providerSetting : 'manual');

        // Find the concrete provider class using the verification provider manager
        $providerConcrete = VerificationProviderManager::find($provider);

        // Check if the provider class exists and bind it to the contract
        if (class_exists($providerConcrete)) {
            app()->bind(VerificationContract::class, $providerConcrete);
        } else {
            // Safe fallback layout map execution to prevent a type mismatch error
            $displayProvider = is_string($provider) ? $provider : 'Unknown';
            throw new \Exception(__(":x Verification processor not found.", ["x" => ucfirst($displayProvider)]));
        }
    }
}