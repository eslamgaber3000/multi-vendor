<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use Throwable;

class PaymentController extends Controller
{
    public function create(Order $order)
    {

        return view(
            'front.payments.create',
            ['order' => $order]
        );
    }


    public function createStripePaymentIntent(Order $order)
    {


        $stripe = new StripeClient(config('services.stripe.secret_key'));

        try {

            $amount = round($order->orderItems->sum(function ($item) {
                return $item->product_price * $item->quantity; //amount in fils
            }));
            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $amount,
                'currency' => $order->currency,
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],

            ]);
            return response()->json(['clientSecret' => $paymentIntent->client_secret]);


        } catch (Throwable $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return response(['error' => $e->getMessage()], 500);


        }
    }


    // handle return url after payment
    public function stripeReturnUrl(Request $request, Order $order)
    {
        // we need to verify the payment status
        try {

            $request ->validate([
                'payment_intent' => 'required|string',
            ]);
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
            $paymentIntent = $stripe->paymentIntents->retrieve(
                $request->input('payment_intent'),
                []
            );

            // check payment status
            if ($paymentIntent->status == 'succeeded') {
                // insert payment record in payments table try not use mass assignment
                $payment = Payment::forceCreate([
                    'order_id' => $order->id,
                    'payment_method' => 'stripe',
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'transaction_id' => $paymentIntent->id,
                    'transaction_details' => json_encode($paymentIntent),
                    'status' => 'processing',
                ]);

                $payment->save();
                //   update order payment status
                $order->payment_status = 'pending';
                $order->status = 'processing';
                $order->save();

                return redirect()->route('front.home', $order->id)
                    ->with('info', 'Payment successful! Your order is being processed.');
            }
        } catch (Throwable $e) {
            Log::error('Stripe Return URL Error: ' . $e->getMessage());
            return redirect()->route('front.home', $order->id)
                ->with('info', 'There was an error processing your payment. Please try again.');
        }

    }

}


