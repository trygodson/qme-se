<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IStateRepository;

class StateController extends Controller
{
    private $stateRepository;

    public function __construct(IStateRepository $stateRepository) {
        $this->stateRepository = $stateRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/states/all",
     *      operationId="stateindex",
     *      tags={"States"},
     *      summary="Get list of states",
     *      description="Returns list of states",
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
        $state = $this->stateRepository->querable()->where('id', '>', 0)->get();
        return response()->json($state, 200);
    }
}
