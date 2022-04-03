<?php

namespace App\Services;

class StripePaymentService
{
    public function CreateCardDetails($inputs)
    {
        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'amount' => $inputs['amount'],
        //     'currency' => 'INR',
        //     'customer' => $inputs['id'],
        //     'payment_method' => '{{PAYMENT_METHOD_ID}}',
        // ]);


        // \Stripe\SetupIntent::create([
        //     'payment_method_types' => ['card_present'],
        //     'customer' => Auth::id(),
        //   ]);

        // $customer = \Stripe\Customer::create();

        // dd(1);
    }
}
