<?php
namespace App\Helpers;

class VerifyAccountNumber 
{

    public function verifyAccountNumber( $account_number, $bank_code )
    {

        $curl = curl_init();
  
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number={$account_number}&bank_code={$bank_code}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_c5bf0023b14b1a1ca0b56678c05534b14a311740",
            "Cache-Control: no-cache",
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          $response = json_decode($response);
          return $response;

          /**
           *  RESPONSE TO BE RETURNED
           *    {
           *    "status": true,
           *    "message": "Account number resolved",
           *    "data": {
           *             "account_number": "0001234567",
           *             "account_name": "Doe Jane Loren",
           *             "bank_id": 9
           *         }
           *    }
           */
        }

    }

}