<?php

namespace App\Http\Controllers\v1;

use App\Models\Activity;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Interfaces\IActivityRepository;
use App\Http\Requests\ActivityRequest\CreateActivityRequest;

class ActivityController extends Controller
{

    private $activityRepository;

    public function __construct(IActivityRepository $activityRepository) {
        $this->activityRepository = $activityRepository;
    }

     /**
     * @OA\Post  (
     *     path="/api/v1/activity/add",
     *     tags={"Activity"},
     *     summary="system admin creates activity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateActivityRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function store(CreateActivityRequest $request){
  
        
        $activity= $this->activityRepository->add($request->all());

        return response()->json($activity, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/activity/get/{id}",
     *      operationId="getActivities",
     *      tags={"Activity"},
     *      summary="Get activity by id",
     *      description="Returns activity by id",
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

    public function show($id){
        // $druglist = $this->activityRepository->getById();
        // return response()->json($druglist, 200);
    }
}
