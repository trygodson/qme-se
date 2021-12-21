<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

      /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="One Medy API Documentation",
     *      description="One Medy APi Service to be consumed by client Application",
     *      @OA\Contact(
     *          email="info@walexbiznig.com"
     *          
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
    

     *
     * @OA\Tag(
     *     name="One Medy Service",
     *     description="API Endpoints of One"
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
