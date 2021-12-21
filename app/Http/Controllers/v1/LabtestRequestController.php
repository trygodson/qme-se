<?php

namespace App\Http\Controllers\v1;


use Illuminate\Http\Request;
use App\Models\LabtestRequest;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Interfaces\ILabTestRequestRepository;
use App\Http\Requests\LabtestRequest\CreateLabRequest;

class LabtestRequestController extends Controller
{
    //
    private $labTestRequest;

    public function __construct(ILabTestRequestRepository $labTestRequest)
    {
        $this->labTestRequest = $labTestRequest;
    }


    /**

     * @OA\Post  (

     *     path="/api/v1/labtestrequest/add",

     *     tags={"Labtest Request"},

     *     summary="Create a new test request to the Labs.",

     *     @OA\RequestBody(

     *         @OA\MediaType(

     *             mediaType="application/json",

     *             @OA\Schema(

     *                 type="object",

     *                 ref="#/components/schemas/CreateLabRequest",

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

    public function store(CreateLabRequest $request)
    {
        $labTestRequest = $this->labTestRequest->add($request->all());

        return response()->json($labTestRequest, 200);
    }


     /**

     * @OA\Get(

     *      path="/api/v1/labtestrequests",

     *      operationId="getAllTestRequests",

     *      tags={"Labtest Request"},

     *      summary="Return a json array of all the tests requests sent to the labs.",

     *      description="Returns all test requests both the completed and uncompleted sent to the Laboratory. If iscompleted is placed in the URL as parameter with a value of
     * 1, it will return all completed tests. The opposite happens if the value of iscompleted is made 0",

     *      @OA\Parameter(

     *         name="iscompleted",

     *         in="parameter",

     *         required=false,

     *         description="Status of the Lab test",



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

    public function getLabTestRequests()
    {

        try{

            $labtestRequest = app(Pipeline::class)
                        ->send(LabtestRequest::query())
                        ->through([
                            \App\QueryFilters\Labtests\IsCompleted::class
                        ])
                        ->thenReturn()
                        ->paginate(10)
                        ->all();

            return response()->json($labtestRequest, 201);

        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);

        }

    }

    /**

     * @OA\Patch  (

     *     path="/api/v1/doctor/labtest/complete/{id}",

     *     tags={"Labtest Request"},

     *     summary="Set a lab test request as completed.",

     *     @OA\RequestBody(

     *         @OA\MediaType(

     *             mediaType="application/json",

     *             @OA\Schema(

     *                 type="object",

     *                 ref="#/components/schemas/CreateLabRequest",

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

    public function complete($id)
    {
        $data = [
            'iscompleted'=>true
        ];
        $labTestRequest = $this->labTestRequest->update($id, $data);

        return response()->json($labTestRequest, 200);
    }


      /**
     * @OA\Get(
     *      path="/api/v1/labtestrequest/tenant",
     *      operationId="TenantId",
     *      tags={"Labtest Request"},
     *      summary="Get list of labtest request by tenant id",
     *      description="Returns list all labtest requests by passing a tenant id query parameter",
     *      @OA\Parameter(
     *         name="tenant_id",
     *         in="query",
     *         description="Tenant id",

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
    public function getLabTestRequestByTenantId()
    {

        try{

            $labtestRequest = app(Pipeline::class)
                        ->send(LabtestRequest::query())
                        ->through([
                            \App\QueryFilters\TenantId::class,
                            \App\QueryFilters\Labtests\IsCompleted::class
                        ])
                        ->thenReturn()
                        ->paginate(10);

            return response()->json($labtestRequest, 201);

        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);

        }

    } 


     /**
     * @OA\Patch(
     *      path="/api/v1/labtestrequest/result/{labtest_id}",
     *      operationId="TenantId",
     *      tags={"Labtest Request"},
     *      summary="Post labtest result and conclusion",
     *      description="Post labtest result and conclusion",
     *      @OA\Parameter(
     *         name="tenant_id",
     *         in="query",
     *         description="Tenant id",

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
    public function postResult(Request $request, $id)
   {
        $data = [
            'result' => $request->result,
            'conclusion' => $request->conclusion,
            'iscompleted' => 1
        ];

        try {
            //code...
            $labTestRequest = $this->labTestRequest->update($id, $data);
            
            return response()->json( $labTestRequest, 200 );

        } catch (\Throwable $th) {
            
            return response()->json($th->getMessage(), 400);
        }
       
   }
}
