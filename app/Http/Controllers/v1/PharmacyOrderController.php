<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Models\PharmacyOrder;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Interfaces\IPharmacyOrderRepository;
use App\Http\Requests\PharmacyRequest\CreatePharmacyOrderRequest;

class PharmacyOrderController extends Controller
{
    private $pharmacyorderRepository;

    public function __construct(IPharmacyOrderRepository $pharmacyorderRepository) {
        $this->pharmacyorderRepository = $pharmacyorderRepository;
    }

      /**
     * @OA\Get(
     *      path="/api/v1/pharmacy/requests/all",
     *      operationId="index",
     *      tags={"Pharmacy"},
     *      summary="Get list of pharmacy requests",
     *      description="Returns list all pharmacy requests",
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
        $pharmacyorder = $this->pharmacyorderRepository->getAll();
        return response()->json($pharmacyorder, 200);
    }

    public function show(CreatePharmacyOrderRequest $request){

    }

      /**
     * @OA\Get(
     *      path="/api/v1/pharmacyorder/tenant",
     *      operationId="TenantId",
     *      tags={"Pharmacy Orders"},
     *      summary="Get list of pharmacy orders by tenant id",
     *      description="Returns list all pharmacy orders by tenant id",
     *      @OA\Parameter(
     *         name="tenant_id",
     *         in="query",
     *         description="Tenant Id",

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
    public function getByTenantId()
    {

        try{

            $pharmacyorder = app(Pipeline::class)
                        ->send(PharmacyOrder::query())
                        ->through([
                            \App\QueryFilters\TenantId::class,
                        ])
                        ->thenReturn()
                        ->paginate(10);

            return response()->json($pharmacyorder, 200);

        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);

        }

    }  

      /**
     * @OA\Get(
     *      path="/api/v1/pharmacyorder/complete",
     *      operationId="completeOrder",
     *      tags={"Pharmacy Orders"},
     *      summary="complete pharmacy order",
     *      description="set pharmacy order to complete",
     *      @OA\Parameter(
     *         name="tenant_id",
     *         in="query",
     *         description="Tenant Id",

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

    public function completeOrder(Request $request, $id)
   {
        try {
            $data = [
                'iscompleted' => 1
            ];
    
            $response = $this->pharmacyorderRepository->update_($id, $data);
            return response()->json($response, 200);
        } catch (\Throwable $th) { 
            //throw $th;
            return response()->json($th->getMessage(), 400);
        }
   }
}

