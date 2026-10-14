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
     *
     * @param array $data
     * @return array
     */
    protected function pay(array $data) : array
    {
        // FedaPay is now a globally recognized constant thanks to your database injection
        $data['payment_method_id'] = FedaPay;

        // Boot FedaPay payment initiator
        $this->boot($data);

        return [
            'status' => true,
            'public_key' => $this->fedapay->public_key,
            'secret_key' => $this->fedapay->secret_key,
        ];
    }

    /**
     * Boot FedaPay payment processor
     *
     * @param array $data
     * @return void
     */
    protected function boot($data)
    {
        $this->data = $data;

        $this->paymentCurrency();

        $this->fedapay = $this->paymentMethodCredentials();

        // Ensure keys are configured in the admin panel before proceeding
        if (!$this->fedapay->secret_key || !$this->fedapay->public_key) {
            throw new GatewayInitializeFailedException(__("FedaPay API keys are missing. Please configure them in the admin panel."));
        }
    }

    /**
     * Method initiateGateway
     *
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function initiateGateway($data)
    {
        $this->setPaymentType($data['payment_type']);
        $paymentIntent = $this->pay($data);
        
        $data['public_key'] = $paymentIntent['public_key'];
        
        // This will route to resources/views/gateways/fedapay.blade.php
        return view(('gateways.' . $this->gateway()), $data);
    }

    /**
     * Get gateway alias name
     *
     * @return string
     */
    public function gateway(): string
    {
        return "fedapay";
    }

    /**
     * Verify the payment post-transaction
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function verify($request)
    {
        try {
            $data = getPaymentParam($request->params);
            $data['payment_method_id'] = FedaPay;
            $this->setPaymentType($data['payment_type']);
            $this->boot($data);

            // FedaPay redirects back with the transaction 'id' in the URL query string
            $transactionId = $request->id; 
            
            if (empty($transactionId)) {
                throw new GatewayInitializeFailedException(__("Transaction ID not found from FedaPay."));
            }

            // Dynamically set API environment based on Admin Panel settings
            $environment = (isset($this->fedapay->mode) && strtolower($this->fedapay->mode) == 'sandbox') ? 'sandbox-api' : 'api';
            $url = "https://{$environment}.fedapay.com/v1/transactions/{$transactionId}";

            // Call FedaPay REST API to securely verify the transaction status
            $response = Http::withToken($this->fedapay->secret_key)->get($url);

            if ($response->successful()) {
                $result = $response->json();
                
                // FedaPay nests the status under 'v1/transaction' or 'transaction'
                $status = $result['v1/transaction']['status'] ?? $result['transaction']['status'] ?? '';

                if ($status === 'approved') {
                    // Tell Zippay core to finalize the transaction
                    $payment = callAPI(
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
     *
     * @return string
     */
    public function paymentView()
    {
        return 'gateways.'.$this->gateway();
    }
}