<?php

namespace App\Http\Controllers\v1;

use App\Models\DrugList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IDrugListRepository;
use App\Http\Requests\DrugRequest\CreateDrugListRequest;

class DrugListController extends Controller
{
    private $druglistRepository;

    public function __construct(IDrugListRepository $druglistRepository) {
        $this->druglistRepository = $druglistRepository;
    }

      /**
     * @OA\Get(
     *      path="/api/v1/drugs/all",
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
        $druglist = $this->druglistRepository->querable()->where('id', '>', 0)->paginate(10);
        return response()->json($druglist, 200);
    }


     /**
     * @OA\Get(
     *      path="/api/v1/drug/byname/",
     *      operationId="getDrugByName",
     *      tags={"DrugList"},
     *      summary="Get drug by name",
     *      description="Returns drug with the specified name",
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
    public function getByName(){
        $druglist = $this->druglistRepository->getByName();
        return response()->json($druglist, 200);
    }
     /**
     * @OA\Get(
     *      path="/api/v1/drug/byid/",
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
        $druglist = $this->druglistRepository->getById();
        return response()->json($druglist, 200);
    }

      /**
     * @OA\Post  (
     *     path="/api/v1/drug/add",
     *     tags={"DrugList"},
     *     summary="system admin adds drugs list",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateDrugListRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function store(CreateDrugListRequest $request){ 

        // $druglist= $this->druglistRepository->add($request->all());
        foreach($request->all() as $drug){
            $drug=[
                'name'=> $drug["name"],
                'amount'=>$drug["amount"]
            ];
            $drugs=$this->druglistRepository->add($drug);
        }

        return response()->json($drugs, 200);
    }

    public function changeState(Request $request, $id){


        $data = [
            'Isavailable' => $request->status
        ];
        try{
        $tenant = $this->druglistRepository->update_($id, $data);

        return response()->json($tenant, 201);

    } catch (\Throwable $ex) {

        return response()->json($ex->getMessage(), 400);
    }
    }
}
