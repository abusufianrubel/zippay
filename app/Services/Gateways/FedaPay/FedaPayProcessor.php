<?php

namespace App\Services\Gateways\FedaPay;

use App\Services\Gateways\Gateway\Exceptions\GatewayInitializeFailedException;
use App\Services\Gateways\Gateway\PaymentProcessor;
use Illuminate\Support\Facades\Http;
use Exception;

class FedaPayProcessor extends PaymentProcessor
{
    protected $data;
    protected $fedapay;

    /**
     * Initiate the FedaPay payment process
     */
    protected function pay(array $data) : array
    {
        $data['payment_method_id'] = $data['payment_method'];

        $this->boot($data);

        return [
            'status' => true,
            'public_key' => $this->fedapay->public_key,
            'secret_key' => $this->fedapay->secret_key,
            'currency' => $data['currency'] ?? 'USD', 
        ];
    }

    /**
     * Boot FedaPay payment processor
     */
    protected function boot($data)
    {
        $this->data = $data;
        $this->paymentCurrency();

        $this->fedapay = new \stdClass();
        
        // TEMPORARY BYPASS: Hardcode your FedaPay keys here for tonight's testing
        $this->fedapay->public_key = 'pk_sandbox_DebMm2-ipJPeTEXbJ2eS5FAX'; // <--- PASTE KEY HERE
        $this->fedapay->secret_key = 'sk_sandbox_D8t7bL1KMPU8DbSq03uXNh9e'; // <--- PASTE KEY HERE

        // Failsafe check
        if (empty($this->fedapay->secret_key) || empty($this->fedapay->public_key) || $this->fedapay->public_key === 'pk_sandbox_YOUR_FEDAPAY_PUBLIC_KEY') {
            throw new GatewayInitializeFailedException(__("FedaPay API keys are missing. Please replace the placeholder strings in the processor."));
        }
    }

    /**
     * Method initiateGateway
     */
    public function initiateGateway($data)
    {
        $data['payment_method'] = $data['payment_method'] ?? $data['payment_method_id'] ?? null;
        
        $this->setPaymentType($data['payment_type']);
        $paymentIntent = $this->pay($data);
        
        $data['public_key'] = $paymentIntent['public_key'];
        $data['currency'] = $paymentIntent['currency'] ?? $data['currency'] ?? 'USD'; 
        
        return view(('gateways.' . strtolower($this->gateway())), $data);
    }

    /**
     * Get gateway alias name
     */
    public function gateway(): string
    {
        return "fedapay"; 
    }

    /**
     * Verify the payment post-transaction
     */
    public function verify($request)
    {
        try {
            // Escape namespace for global helper
            $data = \getPaymentParam($request->params);
            $data['payment_method_id'] = $data['payment_method'] ?? $data['payment_method_id'];
            
            $this->setPaymentType($data['payment_type']);
            $this->boot($data);

            $transactionId = $request->id; 
            
            if (empty($transactionId)) {
                throw new GatewayInitializeFailedException(__("Transaction ID not found from FedaPay."));
            }

            $environment = (isset($this->fedapay->mode) && strtolower($this->fedapay->mode) == 'sandbox') ? 'sandbox-api' : 'api';
            $url = "https://{$environment}.fedapay.com/v1/transactions/{$transactionId}";

            $response = Http::withToken($this->fedapay->secret_key)->get($url);

            if ($response->successful()) {
                $result = $response->json();
                
                $status = $result['v1/transaction']['status'] ?? $result['transaction']['status'] ?? '';

                if ($status === 'approved') {
                    // Escape namespace for global helper
                    $payment = \callAPI(
                        'GET',
                        $data['redirectUrl'],
                        [
                            'params' => $request->params,
                            'execute' => 'api'
                        ]
                    );

                    $data['transaction_id'] = $payment;
                    return $data;
                }
            }

            throw new GatewayInitializeFailedException(__("FedaPay Payment verification failed or transaction was not approved."));

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Method paymentView
     */
    public function paymentView()
    {
        return 'gateways.'.$this->gateway();
    }
}