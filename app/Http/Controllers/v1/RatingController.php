<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Interfaces\IRatingRepository;
use App\Interfaces\IAppointmentRepository;
use App\Http\Requests\RatingRequest\CreateRatingRequest;

class RatingController extends Controller
{

     
    private $ratingRepository;
    private $appointmentRepository;

    public function __construct(IRatingRepository $ratingRepository, IAppointmentRepository $appointmentRepository) {
        $this->ratingRepository = $ratingRepository;
        $this->appointmentRepository = $appointmentRepository;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all();

        return response()->json($ratings, 200);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        /**
     * @OA\Post  (

     *     path="/api/v1/doctor/rate/{id}",
     *     tags={"Rating"},
     *     summary="rate a doctor",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateRatingRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function store(CreateRatingRequest $request, $doctor_id)
    {
      

            
            
        //create new rating entry
        // $rating = new Rating;
        // $rating->user_id = $request->user_id;
        // $rating->rated_user_id = $request->rated_user_id;
        // $rating->rating = $request->rating;

        $rating= $this->ratingRepository->add($request->all());
        // $rating->save();

         //calculate rating
        //  $rating_scores = Rating::where('doctor_id', $doctor_id)->pluck('rating');

         $rating_score = DB::table('ratings')->where('user_id', $doctor_id)->sum('rating');
        // return $rating_score;

        // update doctor table with rating score
        $doctor_rating = $rating->score;
        $doctor = Doctor::where('user_id', $doctor_id)->first();
        $doctor->ratingcount = $rating_score;
        $doctor->ratercount = $doctor->ratercount +1;
        
        $doctor_rating_score = $doctor->ratingcount/$doctor->ratercount;

        $doctor->rating = $doctor_rating_score;

        $data = [
            'ratingcount'=>$rating_score,
            'ratercount'=>$doctor->ratercount +1,
            'rating'=>$doctor_rating_score
        ];

        $rating= $this->ratingRepository->update($doctor_id, $data);

        // $doctor->save();
        $rated = [
            'rated'=>1
        ];
        $appointment_rated=$this->appointmentRepository->update_($request->appointment_id, $rated);


        



        return response()->json(['message'=>'rating added successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

         /**
     * @OA\Get  (
     *     path="/api/v1/doctor/rating/{id}",
     *     tags={"Rating"},
     *     summary="Get doctor's rating",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateRatingRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function show($id)
    {
        $doctor = User::findOrFail($id);
       $rating = $doctor->rating/$doctor->no_of_ratings;
        // return $doctor->no_of_ratings;
        return response()->json($rating, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
