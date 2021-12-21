<?php

namespace App\Helpers;

class VerifyPaymentGateway
{
private $payment;

    // public function __construct($id, $ref){
    //    $pay = new PaymentVerification();
    //     if($id == 1){
    //         $payment =$pay->Paystack($ref);
    //         return $payment;
    //     }elseif($id == 2){
    //         $payment = $pay->Flutterwave($ref);
    //         return $payment;
    //     }elseif($id == 4){
    //        // $pay = new Wallet();
    //     }

    // }

    public static function verify($id, $ref){
        $pay = new PaymentVerification();
        if($id == 1){
            $payment =$pay->Paystack($ref);
            return $payment;
        }elseif($id == 2){
            $payment = $pay->Flutterwave($ref);
            return $payment;
        }elseif($id == 4){
           // $pay = new Wallet();
        }
    }
}
