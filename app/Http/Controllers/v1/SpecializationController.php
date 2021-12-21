<?php

namespace App\Http\Controllers\v1;


use App\Interfaces\ISpecializationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\ChangeStateRequest;
use App\Http\Requests\SpecializationRequest\CreateSpecializationRequest;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    private $data;




    public function __construct(ISpecializationRepository $data)
    {
        $this->data = $data;

    }
    /**
     * @OA\Post  (

     *     path="/api/v1/specialization/create",
     *     tags={"Administrator"},
     *     summary="register a specialization",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateSpecializationRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  register(CreateSpecializationRequest $request)
    {

        try {


            $action = $this->data->add($request->all());

            if ($action == true)
            {
                return response()->json($action, 201);

            } else
            {
                return response()->json(["message"=>"An Enrror was encountered "], 400);
            }
        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }

      /**
     * @OA\Get(
     *      path="/api/v1/specialization",
     *      operationId="getSpecializations",
     *      tags={"ApplicationData"},
     *      summary="Get list of specialization",
     *      description="Returns list of all specialization",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Size",

     *      ),
     *         @OA\Parameter(
     *         name="search",
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
    public function getallspecializations(Request $query)
    {
        $get=$this->data->querable()->where('isdeleted',false)->where('isactivated',true)->where('name', 'like', '%'.$query->search.'%')->get();

        return  response()->json($get,200);
    }


            /**
     * @OA\Patch  (

     *     path="/api/v1/specialization/changestate/{id}",
     *     tags={"Administrator"},
     *     summary="change the state of a specialization",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Specialization Id",

     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangeStateRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  adminchangestate($id,ChangeStateRequest $request)
    {

        try {

            $action = $this->data->update_($id, $request->all());
            return response()->json($action, 200);
        } catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }
     /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Specializations Id",

     *      ),
     *     path="/api/v1/specializationdetail/{id}",
     *     tags={"ApplicationData"},
     *     summary="to get specialization detail",
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getspecialization($id)
    {

        $action = $this->data->getById($id);
        return response()->json($action, 200);
    }

    
}
