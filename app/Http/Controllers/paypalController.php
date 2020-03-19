<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class paypalController extends Controller
{
    public function execute()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'Ac-Yyy9bzD_LPiKoN70zmDMlDouprM_ZGDuETME1G4g11EFaxGCcprPtwpclm-17c9Jz7NvkEgg1OG2l',     // ClientID
                'EHv3EvuOjqR7z0CTQrBiwvT9TmsceM1NEL_FhQ1UtMCvHIg4AevEhoaRZ7pjgjpLLhtkumljte9pjFcF'      // ClientSecret
            )
    );

    $paymentId = request('paymentId');
    $payment = Payment::get($paymentId, $apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId(request('PayerID'));

    $price = request('price');

    $transaction = new Transaction();
    $amount = new Amount();
    $details = new Details();

    $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal($price - 2.5);

    $amount->setCurrency('USD');
    $amount->setTotal($price);
    $amount->setDetails($details);
    $transaction->setAmount($amount);

    $execution->addTransaction($transaction);

    $result = $payment->execute($execution, $apiContext);



    return response()->redirectTo('http://localhost:4200/purchases');
    }
}
