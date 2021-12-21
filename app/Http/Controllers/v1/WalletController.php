<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Interfaces\IOtpRepository;
use App\Helpers\CustomNotification;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Interfaces\IWalletRepository;
use App\Http\Requests\WalletRequest\IDRequest;
use App\Http\Requests\WalletRequest\LoginRequest;
use App\Http\Requests\WalletRequest\UserRequest ;
use App\Http\Requests\WalletRequest\VerifyRequest;
use App\Http\Requests\WalletRequest\UpdateUserRequest;
use App\Http\Requests\WalletRequest\ChangePasswordRequest;



class WalletController extends Controller
{


    private $_walletdata;
    private $_user;
 
     public function __construct(IWalletRepository $walletdata, IUserRepository $user)
    {
   
        $this->_walletdata=$walletdata;
        $this->_user=$user;
    }


     /**
     * @OA\Get(
     *      path="/api/v1/getwallet-detail",
     *      operationId="getWalletInfo",
     *      tags={"Finances"},
     *      summary="Get wallet detail of a user",window
     *      description="Returns wallet detail",

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
    public function getwalletdetail()
    {
        $user = request()->user();
        $action = $this->_walletdata->querable()->where('user_id',$user->id)->first();
        return response()->json($action, 200);
    }


    public function creditWallet(Request $request, $user_id)
    {
        $wallet = $this->_walletdata->querable()->where('user_id', $user_id)->first();
        $balance = $wallet->balance;
        $amount = $request->balance;

        if($request->credit == 1){
            $new_balance = $balance+$amount;
        }else if($request->credit == 0){
            $new_balance = $balance-$amount;
        }
       
        $data = [
            'balance'=>$new_balance
        ];
        
        $action = $this->_walletdata->credit($wallet, $data);
        return response()->json($action, 200);
    }
}
