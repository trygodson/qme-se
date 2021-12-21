<?php

namespace App\Http\Controllers\v1;

use App\Helpers\CustomNotification;
use App\Helpers\makeTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IWalletRepository;
use App\Interfaces\IWithdrawalRepository;
use App\Interfaces\IWalletTransactionRepository;
use App\Http\Requests\WalletRequest\CreateWithdrawalRequest;
use App\Http\Requests\WalletRequest\UpdateWithdrawalRequest;
use App\Interfaces\IBankdetailRepository;
use App\Interfaces\ITransactionRepository;
use App\Models\Webhook;

class WithdrawalsController extends Controller
{
    private $wallet;
    private $withdrawal;
    private $wallet_tran;
    private $bank;
    private $transaction;
    public function __construct(IWalletRepository $wallet, IWalletTransactionRepository $wallet_tran, IWithdrawalRepository $withdrawal, IBankdetailRepository $bank, ITransactionRepository $transaction)
    {
        $this->wallet = $wallet;
        $this->withdrawal = $withdrawal;
        $this->wallet_tran = $wallet_tran;
        $this->bank = $bank;
        $this->transaction = $transaction;
    }

    /**
     * @OA\Post  (

     *     path="/api/v1/wallet/withdraw",
     *     tags={"Withdrawal"},
     *     summary="Make a withdrawal request",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateWithdrawalRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function withdraw(CreateWithdrawalRequest $request){
            $user = request()->user();
            $check = $this->withdrawal->querable()->where('user_id', $user->id)->where('status', 'processing')->first();

            if($check){

                return response()->json(['message' => 'You already have a pending request'],400);
            }else{
                $wallet = $user->wallet;
                if($request->amount <= $wallet->balance){
                        $withdraw = $this->withdrawal->add([
                            'user_id' => $user->id,
                            'amount' => $request->amount,
                            'status' => 'processing'
                        ]);
                if($withdraw){
                    return response()->json($withdraw, 200);
                }
                }else{
                    return response()->json(['message' => 'Insufficient Balance'], 400);
                }
            }

    }

  /**
     * @OA\Get(
     *      path="/api/v1/wallet/withdrawals",
     *      operationId="getWithdrawals",
     *      tags={"Withdrawal"},
     *      summary="To get all withdrawals",
     *      description="Returns Withdrawals requests",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Size",

     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getwithdrawals(){
        $withdrawals = $this->withdrawal->querable()->with('user')->paginate(10);
        return response()->json($withdrawals, 200);
    }

        /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="user Id",

     *      ),
     *     path="/api/v1/wallet/withdrawals/{id}",
     *     tags={"Withdrawal"},
     *     summary="to get withdrawals request by userid",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getwithdrawalsbyuserid($id){
        $withdrawals = $this->withdrawal->querable()->where('user_id', $id)->with('user')->paginate(10);
        return response()->json($withdrawals, 200);
    }


        /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="withdrawal Id",

     *      ),
     *     path="/api/v1/wallet/withdraw/{id}",
     *     tags={"Withdrawal"},
     *     summary="to get a withdrawal request by withdrawal id",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getwithdrawalbyid($id){
        $withdrawal = $this->withdrawal->getById($id);

        return  response()->json($withdrawal, 200);
    }

         /**
     * @OA\Patch  (

     *     path="/api/v1/wallet/withdraw/{id}",
     *     tags={"Withdrawal"},
     *     summary="Update status of withdrawal",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Withdrawal Id",

     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateWithdrawalRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function updatewithdrawal(UpdateWithdrawalRequest $request, $id){
        $user = request()->user();
        if($request->status == "approved"){
            $withdraw = $this->withdrawal->getById($id);
            $user = $withdraw->user;
            $fullname = $user->firstname." ".$user->lastname;
            $bank = $this->bank->querable()->where('user_id', $withdraw->user_id)->first();
            $transaction = new \App\Helpers\MakeTransfer;
            $receipient = $transaction->createTransferRecipient($fullname, $bank->account_number, $bank->sort_code);
            $amount = $withdraw->amount;
            if($receipient->status == true){
                $initiate = $transaction->initiateTransfer($receipient->data->recipient_code, "OneMedy Services", $amount );
                if($initiate->status == true){
                        $withdraw->update([
                            'transfer_code' => $initiate->data->transfer_code,
                            'authorizer_id' => $user->id
                        ]);
                        return response()->json(['message' => 'Transfer has been initialized' ], 200);
                }else{
                    return response()->json(['message' => 'Unable to initialize transfer' ], 400);
                }
            }else{
                return response()->json(['message' => 'Unable to create transfer receipient' ], 400);
            }

        }

    }

    public function confirmation(){

            // // only a post with paystack signature header gets our attention
            //  if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('x-paystack-signature', $_SERVER) )
            //      exit();
            // Retrieve the request's body
            $input = @file_get_contents("php://input");
            // define('PAYSTACK_SECRET_KEY','sk_test_c5bf0023b14b1a1ca0b56678c05534b14a311740');
            // // validate event do all at once to avoid timing attack
            // if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY))
            //     exit();

            http_response_code(200);

            // // parse event (which is json string) as object
            // // Do something - that will not take long - with $event
           $event = json_decode($input);
        //    $webhook = Webhook::create([
        //         'purpose' => '$event->data->amount'
        //     ]);
          //  return response()->json($webhook, 200);
           // return response()->json($event->data->amount, 200);

            $withdraw = $this->withdrawal->querable()->where('transfer_code', $event->data->transfer_code)->first();
          //   return response()->json($withdraw, 200);
            if($event->event == "transfer.success"){
                $withdraw->update(['status' => 'success']);
                $transaction_credit = $this->transaction->add([
                    "reference_id" => $event->data->transfer_code,
                    "isdebit"   => 0,
                    "payment_description" => "Withdrawal Payment",
                    "amount" => ($event->data->amount / 100),
                    "payment_methods_id" => 1,
                    "user_id" => $withdraw->user_id
                ]);

                $wallet = $this->wallet->querable()->where('user_id', $withdraw->user_id)->first();
                $newbalance = $wallet->balance - ($event->data->amount / 100);
                $wallet->update([
                    'balance' => $newbalance
                ]);

                $wallet_tran = $this->wallet_tran->add([
                    'wallet_id' => $wallet->id,
                    'amount' => ($event->data->amount / 100),
                    'status' => 1,
                    'action' => 'debit',
                    'purpose' => 'Debit for Withdrawal'
                ]);

                $transaction_debit = $this->transaction->add([
                    "reference_id" => $wallet_tran->id,
                    "isdebit"   => 1,
                    "payment_description" => "Withdrawal Debit",
                    "amount" => ($event->data->amount / 100),
                    "payment_methods_id" => 4,
                    "user_id" => $withdraw->user_id
                ]);
                $body = "Your withdrawal Request Has been Processed Successfully";
                $toname = $withdraw->user->firstname." ".$withdraw->user->lastname;
                $toeamil = $withdraw->user->email;
                $subject =  "Withdrawal Request";
                CustomNotification::sendmail($body, $toname, $toeamil, $subject);

            }elseif($event->event == "transfer.failed"){
                $withdraw->update(['status' => 'failed',
                                    'note'  => 'Unable to Process, Please try again'
            ]);
                $body = "Your withdrawal Request failed to Process";
                $toname = $withdraw->user->firstname." ".$withdraw->user->lastname;
                $toeamil = $withdraw->user->email;
                $subject =  "Withdrawal Request";
                CustomNotification::sendmail($body, $toname, $toeamil, $subject);
            }
            // exit();

    }
}
