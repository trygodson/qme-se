<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IBankdetailRepository;
use App\Http\Requests\Bankdetail\CreateBankDetailRequest;

class BankdetailController extends Controller
{

    private $bankdetailRepository;

    public function __construct(IBankdetailRepository $bankdetailRepository) {
        $this->bankdetailRepository = $bankdetailRepository;
    }


      /**
     * @OA\Post  (
     *     path="/api/v1/bank-detail/add",
     *     tags={"Bank Detail"},
     *     summary="user adds his bank details",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateBankDetailRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */


    public function create(CreateBankDetailRequest $request)
    {

        $user = request()->user();

        $has_bankdetails = $this->bankdetailRepository->querable()->where('user_id', $user->id)->first();
        if($has_bankdetails){


            $request['user_id'] = $user->id;
            $bankdetail= $this->bankdetailRepository->update_($user->id, $request->all());
            return response()->json($bankdetail, 200);

        }else{
            $user = request()->user();

        $request['user_id'] = $user->id;
        $bankdetail= $this->bankdetailRepository->add($request->all());
        return response()->json($bankdetail, 200);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/bank-detail/byid/",
     *      operationId="getById",
     *      tags={"Bank Detail"},
     *      summary="Get bank detail by user id",
     *      description="Returns the bank detail of the specified user",
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

    public function getById()
    {
        $bankdetail = $this->bankdetailRepository->getById();
        return response()->json($bankdetail, 200);
    }

}
