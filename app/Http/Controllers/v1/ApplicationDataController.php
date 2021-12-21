<?php

namespace App\Http\Controllers\v1;



use App\Http\Controllers\Controller;




class ApplicationDataController extends Controller
{





      /**
     * @OA\Get(
     *      path="/api/v1/getallavailability",
     *      operationId="getApplicationDatas",
     *      tags={"ApplicationData"},
     *      summary="Get list of statuses away,available,offline",
     *      description="Returns list of all statuses for avilability",

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
    public function getallavailabilty()
    {


        return  response()->json(["away"=>"away","offline"=>"offline","online"=>"online"],200);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/getallappointmentstatus",
     *      operationId="getApplicationDatas",
     *      tags={"ApplicationData"},
     *      summary="Get list of statuses accept,decline",
     *      description="Returns list of all statuses for avilability",

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
    public function getallappointmentstatus()
    {
       return  response()->json(["accept"=>"accept","decline"=>"decline"],200);
    }

}
