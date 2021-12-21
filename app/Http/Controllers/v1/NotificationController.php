<?php

namespace App\Http\Controllers\v1;

use Throwable;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Interfaces\INotificationRepository;
use App\Http\Requests\NotificationRequest\CreateNotificationRequest;

class NotificationController extends Controller
{

    private $notificationRepository;
    private $_authdata;

    public function __construct(INotificationRepository $notificationRepository, IUserRepository $authdata) {
        $this->_authdata=$authdata;
        $this->notificationRepository = $notificationRepository;
    }

   /**
     * @OA\Post  (
     *     path="/api/v1/notification/add",
     *     tags={"Notification"},
     *     summary="system admin creates notification",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateNotificationRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function store(CreateNotificationRequest $request){
        
        $users = $this->_authdata->getAll();

        foreach ($users as $user) {
        $request['user_id']= $user->id;
        $notification= $this->notificationRepository->add($request->all());
        }

        return response()->json($notification, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/notification/get/{id}",
     *      operationId="getNotificationById",
     *      tags={"Notification"},
     *      summary="Get notification by user id",
     *      description="Returns notification by id",
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

    public function show($user_id){

        try{
            $notification = Notification::where('user_id','=', $user_id)->where('isread',0)->get();
            return response()->json($notification, 200);
        }catch(\Throwable $error){
            return response()->json(['message'=>'bad request!'], 400);
        }
        }
        
}
