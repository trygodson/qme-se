<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Interfaces\IWalletTransactionRepository;

use Illuminate\Http\Request;

class WalletTransactionController extends Controller
{
    //
    private $walletTx;

    public function __construct(IWalletTransactionRepository $walletTx)
    {
        $this->walletTx = $walletTx;
    }

      /**
     * @OA\Get(
     *      path="/api/v1/wallet-tx/all",
     *      operationId="getDrugs",
     *      tags={"DrugList"},
     *      summary="Get list of drugs",
     *      description="Returns list of drugs",
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

    public function index(){
        $wallet = $this->walletTx->getAll();
        return response()->json($wallet, 200);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/wallet-tx/byid",
     *      operationId="getDrugById",
     *      tags={"DrugList"},
     *      summary="Get drug by id",
     *      description="Returns drug with the specified id",
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
    public function getById(){
        $wallet = $this->walletTx->getById();
        return response()->json($wallet, 200);
    }

     //
     /**

     * @OA\Post  (

     *     path="/api/v1/wallet-tx/add",

     *     tags={"Wallet Transaction"},

     *     summary="Add data into the wallet transaction table.",

     *     @OA\RequestBody(

     *         @OA\MediaType(

     *             mediaType="application/json",

     *             @OA\Schema(

     *                 type="object",

     *                 ref="#/components/schemas/CreateLabtestRequest",

     *             )

     *         )

     *     ),

     *      @OA\Response(

     *          response=401,

     *          description="Unauthenticated",

     *      ),
     * 
     *      

     * ),
     * 
     * 

     */

    public function create(Request $request)
    {
        $walletTx = $this->walletTx->add($request->all());

        return response()->json($walletTx, 200);
    }
}  
