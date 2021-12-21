<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ITransactionRepository;
use App\Interfaces\ITransactionsRepository;

class TransactionController extends Controller
{
    //
    private $transaction;

    public function __construct(ITransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

      /**
     * @OA\Get(
     *      path="/api/v1/transactions/all",
     *      operationId="index",
     *      tags={"Wallet Transaction"},
     *      summary="Get list of all transactions",
     *      description="Returns list of transactions",
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
        $tx = $this->transaction->querable()->with('user')->with('payment_method')->paginate(3);
        return response()->json($tx, 200);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/transactions/byid/{id}",
     *      operationId="getById",
     *      tags={"Wallet Transaction"},
     *      summary="Get transactions by id",
     *      description="Returns all transactions with the specified user id",
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
    public function getById($id){
        $tx = $this->transaction->getById($id);
        return response()->json($tx, 200);
    }
}
