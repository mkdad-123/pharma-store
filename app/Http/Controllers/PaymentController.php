<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createCharge(Request $request){

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
           'amount' => $request->amount,
           'currency' => $request->currency,
           'source' => $request->stripToken,
           'description' => 'Charge for order #1234',
        ]);

        return response()->json([
           'status' => 200,
           'message' => 'Charge created successfully',
           'data '=> ['charge_id' => $charge->id ]
        ]);
    }

}
