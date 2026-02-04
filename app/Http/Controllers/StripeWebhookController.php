<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handleStripeWebhook(Request $request) {
        

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
             case 'payment_intent.succeeded':
                // need to update payment status in db and send email to user
                $paymentIntent = $event->data->object; // contains a \Stripe\Payment
                $paymentTransaction = Payment::where('transaction_id', $paymentIntent->id)->first();
                Log::info('Strip Payment Succeeded',
                  ['event id' => $event->id , 'paymentIntent Id' => $paymentIntent->id]);
                if ($paymentTransaction){   
                    // check Idempotency - only update if not already succeeded
                   if ($paymentTransaction->status === 'succeeded') {

                    Log::info('Payment transaction already succeeded', ['transaction_id' => $paymentIntent->id]);
                    return ;
                    }
                    // make consetency by using transaction
                    DB::transaction(function () use ($paymentTransaction) {                    
                    $paymentTransaction->update(['status' => 'succeeded']);
                    $paymentTransaction->order->status='completed';
                    $paymentTransaction->order->payment_status='paid';
                    $paymentTransaction->order->save();
                    });
                     
                }else {
                    Log::error('Payment transaction not found', ['transaction_id' => $paymentIntent->id]);
                }
                           
              

            break;
        }
        return response()->json(['ok' => true], 200);
    }
}
