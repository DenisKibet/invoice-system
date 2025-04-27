<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends BaseController
{
    public function createCheckoutSession()
    {
        // Set your Stripe secret key
        // Stripe::setApiKey('your_stripe_secret_key');
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 2000, // Amount in cents
                        'product_data' => [
                            'name' => 'Subscription',
                            'description' => 'Monthly subscription',
                        ],
                    ],
                    'quantity' => 5,
                ]],
                'mode' => 'payment',
                'success_url' => base_url('payment/success'),
                'cancel_url' => base_url('payment/cancel'),
            ]);

            // Redirect to Stripe Checkout
            return redirect()->to($checkout_session->url);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('Stripe/payment_success');
    }

    public function cancel()
    {
        return view('Stripe/payment_cancel');
    }
    public function handleWebhook()
    {
        Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
    
        $payload = $this->request->getBody();
        $sig_header = $this->request->getHeaderLine('Stripe-Signature');
        $event = null;
    
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, getenv('STRIPE_WEBHOOK_SECRET')
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            error_log('Invalid payload: ' . $e->getMessage());
            return $this->response->setStatusCode(400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            error_log('Invalid signature: ' . $e->getMessage());
            return $this->response->setStatusCode(400);
        }
    
        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentFailed($paymentIntent);
                break;
            case 'charge.succeeded':
                $charge = $event->data->object;
                $this->handleChargeSucceeded($charge);
                break;
            case 'charge.failed':
                $charge = $event->data->object;
                $this->handleChargeFailed($charge);
                break;
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->handleSubscriptionEvent($event->type, $subscription);
                break;
            default:
                error_log('Received unhandled event type ' . $event->type);
                break;
        }      return $this->response->setStatusCode(400);
    
        return $this->response->setStatusCode(200);
    }
    
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Log the successful payment intent
        log_message('info', 'Payment Intent Succeeded: ' . $paymentIntent->id);
        
        // Update your database or perform any necessary actions
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updatePaymentStatus($paymentIntent->id, 'completed');
    }
    
    private function handlePaymentIntentFailed($paymentIntent)
    {
        // Log the failed payment intent
        log_message('error', 'Payment Intent Failed: ' . $paymentIntent->id);
        
        // Update your database or notify the user
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updatePaymentStatus($paymentIntent->id, 'failed');
    }
    
    private function handleChargeSucceeded($charge)
    {
        // Log the successful charge
        log_message('info', 'Charge Succeeded: ' . $charge->id);
        
        // Update your database or perform any necessary actions
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updateChargeStatus($charge->id, 'completed');
    }
    
    private function handleChargeFailed($charge)
    {
        // Log the failed charge
        log_message('error', 'Charge Failed: ' . $charge->id);
        
        // Update your database or notify the user
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updateChargeStatus($charge->id, 'failed');
    }
    
    private function handleSubscriptionEvent($eventType, $subscription)
    {
        // Log the subscription event
        log_message('info', 'Subscription Event: ' . $eventType . ' - ' . $subscription->id);
        
        // Update your database based on the event type
        $subscriptionModel = new SystemSubscriptionModel();
        switch ($eventType) {
            case 'customer.subscription.created':
                $subscriptionModel->createSubscription($subscription);
                break;
            case 'customer.subscription.updated':
                $subscriptionModel->updateSubscription($subscription);
                break;
            case 'customer.subscription.deleted':
                $subscriptionModel->deleteSubscription($subscription->id);
                break;
        }
    }


    
}