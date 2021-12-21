<?php

namespace App\Http\Controllers\v1;

use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IBiodataRepository;
use App\Http\Requests\Biodata\CreateBiodataRequest;

class BiodataController extends Controller
{
    private $biodataRepository;

    public function __construct(IBiodataRepository $biodataRepository) {
        $this->biodataRepository = $biodataRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/v1/biodata/byid/",
     *      operationId="getById",
     *      tags={"Biodata"},
     *      summary="Get bio data by user id",
     *      description="Returns bio data of the specified user",
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
        $biodata = $this->biodataRepository->getById();
        return $biodata;
    }

   //
     /**

     * @OA\Post  (

     *     path="/api/v1/biodata/add",

     *     tags={"Biodata"},

     *     summary="Create a new biodata for a user. Updates if biodata already exists.",

     *     @OA\RequestBody(

     *         @OA\MediaType(

     *             mediaType="application/json",

     *             @OA\Schema(

     *                 type="object",

     *                 ref="#/components/schemas/CreateBiodataRequest",

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
    public function store(CreateBiodataRequest $request)
    {
        $has_biodata = $this->biodataRepository->querable()->where('user_id', $request->user_id)->first();
        if($has_biodata){
            $bmi = $request->weight/$request->height;
            $has_biodata->user_id = $request->user_id;
            $has_biodata->weight = $request->weight;
            $has_biodata->height = $request->height;
            $has_biodata->bmi = $bmi;
            $has_biodata->bloodgroup = $request->bloodgroup;
            $has_biodata->genotype = $request->genotype;
            $has_biodata->age = $request->age;


            $has_biodata->save();
            // $data = [
            //     'user_id' => $request->user_id,
            //     'weight'=> $request->weight,
            //     'height'=> $request->height,
            //     'bmi'=> $bmi,
            //     'bloodgroup'=> $request->bloodgroup,
            //     'genotype'=> $request->genotype
            // ];
            // $biodata= $this->biodataRepository->update_($data);

            return response()->json($has_biodata, 200);
        }else{
            $bmi = $request->weight/$request->height;
            $data = [
                'user_id' => $request->user_id,
                'weight'=> $request->weight,
                'height'=> $request->height,
                'bmi'=> $bmi,
                'bloodgroup'=> $request->bloodgroup,
                'genotype'=> $request->genotype,
                'age'=> $request->age
            ];
            $biodata= $this->biodataRepository->add($data);

            return response()->json($biodata, 200);
        }

        // $bmi = $request->weight/$request->height;
        // $data = [
        //     'user_id' => $request->user_id,
        //     'weight'=> $request->weight,
        //     'height'=> $request->height,
        //     'bmi'=> $bmi,
        //     'bloodgroup'=> $request->bloodgroup,
        //     'genotype'=> $request->genotype
        // ];
        // $biodata= $this->biodataRepository->add($data);

        // return response()->json($biodata, 200);
    }


    public function edit(CreateBiodataRequest $request, $id)
    {
        $bmi = $request->weight/$request->height;
        $data = [
            'user_id' => $request->user_id,
            'weight'=> $request->weight,
            'height'=> $request->height,
            'bmi'=> $bmi,
            'bloodgroup'=> $request->bloodgroup,
            'genotype'=> $request->genotype
        ];
        $biodata= $this->biodataRepository->update_($id, $data);

        return response()->json($biodata, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
