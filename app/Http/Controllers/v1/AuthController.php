<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use App\QueryFilters\Isdeleted;
use Illuminate\Pipeline\Pipeline;
use App\Interfaces\IOtpRepository;
use App\Helpers\CustomNotification;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Interfaces\IWalletRepository;
use App\Interfaces\IAppointmentRepository;
use App\Http\Requests\AuthRequest\IDRequest;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\UserRequest ;
use App\Http\Requests\AuthRequest\VerifyRequest;
use App\Http\Requests\AuthRequest\UpdateUserRequest;
use App\Http\Requests\AuthRequest\ChangePasswordRequest;



class AuthController extends Controller
{


    private $_authdata;
    private $_otpdata;
    private $_walletdata;
    private $appointment;
     public function __construct(IUserRepository $authdata, IOtpRepository $otpdata,IWalletRepository $walletdata, IAppointmentRepository $appointment)
    {
        $this->_authdata = $authdata;
        $this->_otpdata=$otpdata;
        $this->_walletdata=$walletdata;
        $this->appointment = $appointment;
    }
    /**
     * @OA\Post  (
     
     *     path="/api/v1/register",
     *     tags={"Users"},
     *     summary="register user with basic detail",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/RegisterRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  register(UserRequest $request)
    {   
        $code =Str::random(4);
        $email_message='Welcome to One Medy Platform. To continue your registration process, use <b>'.$code.'</b> to sign up';
        try {
         
            
            $action = $this->_authdata->add($request->all());
            $action_create_wallet = $this->_walletdata->create($action->id,$action->phonenumber);
            if ($action == true && $action_create_wallet==true) 
            {
                $this->_otpdata->generate('new_user',$code,$action->id);
                CustomNotification::sendmail($email_message,$action->name,$action->email, 'Welcome To OneMedy'
                 );
                return response()->json($action, 201);
                
            } else 
            {
                return response()->json($action, 400);
            }
        } catch (\Throwable $ex) {
          
            return response()->json($ex->getMessage(), 400);
        }
    }
     /**
     * @OA\Post  (
     
     *     path="/api/v1/resend-otp",
     *     tags={"Users"},
     *     summary="request for new otp after registeration",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/IDRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function  resend(IDRequest $request)
    {   
        $code =Str::random(4);
        $email_message='Welcome to One Medy Platform. To continue your registration process, use <b>'.$code.'</b> to sign up';
        try {
         
            $action = $this->_authdata->getById($request->id);
             if($action==true && $action->isVerified !=true)
             {
                $this->_otpdata->generate('resend_new_user',$code,$action->id);
                CustomNotification::sendmail($email_message,$action->name,$action->email, 'Welcome To OneMedy'
                );
                return response()->json($action, 200);
             }
             else
             {
                return response()->json(['message' => 'Sorry we cant resend OTP cos the account have been verified'], 400);
             }
               
                
          
           
            
        } catch (\Throwable $ex) {
          
            return response()->json($ex->getMessage(), 400);
        }
    }
    /**
     * @OA\Post  (
     
     *     path="/api/v1/login",
     *       tags={"Users"},
     *     summary="login user with email and password",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/LoginRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function login(LoginRequest $request)
    {
        try
        {
        
            $action = $this->_authdata->login($request->all());
            if ($action !=false)
            {
             return  response()->json($action, 200);
            }else
            {
             return response()->json(['message' => 'Bad Credentials'], 400);
            }
        
        
        }catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 400);
        }
        

     
     
    }

      /**
     * @OA\Post  (
     
     *     path="/api/v1/verify",
     *     tags={"Users"},
     *     summary="to verify otp",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/VerifyRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    
    public function verify(VerifyRequest $request)
    {
        try
        {
            
            $action =$this->_otpdata->verify($request['id'], $request['pin']);
            if ($action !=false)
            {
            return  response()->json(['message' => 'Account Verified'], 200);
            }
            else
            {
                return  response()->json(['message' => 'OTP not Valid'], 400);
            }
        
        
        }catch (\Throwable $ex) {
            return response()->json($ex->getMessage(), 400);
        }
        

     
     
    }

    /**
     * @OA\Post  (
      *     tags={"Users"},
     *     path="/api/v1/logout",
     *     summary="logout from the system",
    
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function logout()
    {
        $user = request()->user();
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        $response = [
            'message' => 'Logged out'
        ];
        return response()->json($response, 200);
    }

      /**
     * @OA\Get(
     *      path="/api/v1/userinfo",
     *      operationId="getUserInfo",
     *      tags={"Users"},
     *      summary="Get detail of a user",
     *      description="Returns user detail",

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
    public function getuser()
    {
        $user = request()->user();
        $action = $this->_authdata->getById($user->id);
        return response()->json($action, 200);
    }
  /**
     * @OA\Get(
     *      path="/api/v1/users",
     *      operationId="getUser",
     *      tags={"Administrator"},
     *      summary="Get list of users",
     *      description="Returns list of users",
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
    public function getallusers()
    {
        $pipeline=app(Pipeline::class)
        ->send($this->_authdata->querable())
        ->through([
            Isdeleted::class,
         ])
        ->thenReturn()
        ->paginate(5);
       return  response()->json($pipeline,200);
    }
          /**
     * @OA\Post  (
     
     *     path="/api/v1/forgotpassword",
     *     tags={"Users"},
     *     summary="for user who forgot thier password",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangePasswordRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function forgotpassword(ChangePasswordRequest $request)
    {
        $user=$this->_authdata->querable()->where('email',$request['email'])->first();
        $code =Str::random(4);
        $email_message='reset your passord.Use <b>'.$code.'</b> to set up a new password';
        try {
         
           if($user !=null)
           {
            $this->otpdata->generate('password_reset',$code,$user->id);

            CustomNotification::sendmail($email_message,$user->name,$user->email, 'Password Reset'
            );
            return response()->json(['message' => 'A password Link Has been sent to your email'], 200);
           }else
           {
            return response()->json(['message' => 'This Email Does Not Exisit with One Medy'], 400);
           }
               
                
         
        } catch (\Throwable $ex) {
          
            return response()->json($ex->getMessage(), 400);
        }
    }
     /**
     * @OA\Post  (
     
     *     path="/api/v1/verifyforgotpassword",
     *     tags={"Users"},
     *     summary="for user who forgot thier password",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangePasswordRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function verifyforgotpassword(ChangePasswordRequest $request)
    {
       
        $user=$this->_authdata->querable()->where('email',$request['email'])->first();
    
        
        try {
         
           if($user !=null)
           {
            $check_otp_is_true= $this->otpdata->verifyforgotpassword($user->id,$request->all());
            if($check_otp_is_true==true)
            {
                $user=$this->authdata->changepassword($user->id,$request->all());
                return response()->json(['message' => 'Your Password Have been updated'], 200);
            }else
            {
                return response()->json(['message' => 'OTP not valid'], 200);
            }

        
            
           }else
           {
            return response()->json(['message' => 'This Email Does Not Exisit with One Medy'], 400);
           }
               
                
         
        } catch (\Throwable $ex) {
          
            return response()->json($ex->getMessage(), 400);
        }
    }
             /**
     * @OA\Post  (
     
     *     path="/api/v1/changepassword",
     *     tags={"Users"},
     *     summary="for user who forgot thier password",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangePasswordRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function changepassword(ChangePasswordRequest $request)
    {
        $user = request()->user();
       
        
        try {
            $user=$this->_authdata->changepassword($user->id,$request->all());
            return response()->json(['message' => 'Change o password is successful'], 200);
                
         
        } catch (\Throwable $ex) {
          
            return response()->json($ex->getMessage(), 400);
        }
    }

          /**
     * @OA\Patch  (
     
     *     path="/api/v1/updateuser",
     *     tags={"Users"},
     *     summary="to update user detail",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/UpdateUserRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function updateuser(UpdateUserRequest $request)
    {
        $user = request()->user();
        $action = $this->_authdata->update_($user->id, $request->all());
        return response()->json($action, 200);
    }

    /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,

     *         description="Doctors Id",

     *      ),
     *     path="/api/v1/patient/detailscount/{id}",
     *     tags={"User"},
     *     summary="to get user appointtment statistics",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */

    public function detailscount($id){
        $appointment = $this->appointment->querable()->where('user_id', $id)->get();
        $pending = $this->appointment->querable()->where('user_id', $id)->where('status', 'processing')->get();
        $finished =  $this->appointment->querable()->where('user_id', $id)->where('status', 'completed')->get();
        $canceled =  $this->appointment->querable()->where('user_id', $id)->where('status', 'canceled')->get();

        $response = [
            'total_appointments' => $appointment,
            'pending_appointments' => $pending,
            'completed_appointments' => $finished,
            'canceled_appointments' => $canceled
        ];

        return response()->json($response, 200);
     }


     /**
     * @OA\Get  (
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,

     *         description="User Id",

     *      ),
     *     path="/api/v1/get/user/{id}",
     *     tags={"User"},
     *     summary="To get user details",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
     public function getSingleUser($id)
     {
         try {
            //code...
            $user = $this->_authdata->getById($id);
            return response()->json( $user, 200 );
         } catch (\Throwable $th) {
            //throw $th;
            return response()->json( $th, 400 );
         }
        

     }
}
