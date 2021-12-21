<?php

namespace App\Http\Controllers\v1;



use App\Models\TenantType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Helpers\CustomNotification;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest\ChangeTenant;
use App\Interfaces\IMemberRepository;

use App\Interfaces\ITenantRepository;
use App\Http\Requests\TenantRequest\CreateTenantRequest;
use App\QueryFilters\Name;

class TenantController extends Controller
{
    private $user;
    private $tenant;
    private $member;


    public function __construct(IUserRepository $user, ITenantRepository $tenant, IMemberRepository $member)
    {
        $this->user = $user;
        $this->tenant = $tenant;
        $this->member = $member;
    }

    /**
     * @OA\Post  (

     *     path="/api/v1/tenant/create",
     *     tags={"Tenant"},
     *     summary="register a Tenant",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateTenantRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function create(CreateTenantRequest $request){
        try{

            $data = $request->json()->all();
            $check = $this->user->querable()->where('email', $data['admin']['email'])->orWhere('phonenumber', $data['admin']['phonenumber'])->get();
            if($check->count() > 0){
                return response()->json(['message' => 'Email Or Phone Number has already been registered'], 400);
            }else{
            $password = Str::random(8);
            $body = 'Welcome to Ecare as an Admin, here are your login details Email:'.$request->email.' Password: '.$password.'';
            $subject = "Welcome to Ecare";

            $tenant = $this->tenant->add($data['tenant']);

            $data['admin']['password']=$password;
            $data['admin']['roles_id']=4;
            $data['admin']['statuses_id']=1;
            $user = $this->user->add($data['admin']);

            $assign_role = [
                'tenant_id' => $tenant->id,
                'user_id' => $user->id,
                'tenant_role_id' => 1
            ];
            $member = $this->member->add($assign_role);

            CustomNotification::sendmail($body,$data['admin']['firstname'],$data['admin']['email'],$subject);
            return response()->json("me", 201);
        }

        }catch (\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }





    }

     /**
     * @OA\Get(
     *      path="/api/v1/tenants",
     *      operationId="getTenants",
     *      tags={"Tenant"},
     *      summary="Get list of tenants",
     *      description="Returns list of tenants",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Size",

     *      ),
     *      @OA\Parameter(
     *         name="tenanttypeid",
     *         in="query",
     *         description="the Id of the tenanttype",

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
    public function getAll(){
        $pipeline=app(Pipeline::class)
        ->send($this->tenant->querable()->with('tenanttype'))
        ->through([
            \App\QueryFilters\IsActive::class,
            \App\QueryFilters\Name::class,
            \App\QueryFilters\TenantTypeId::class,
         ])

        ->thenReturn()
        ->paginate(10);
       return  response()->json($pipeline,200);
    }


          /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Tenant id",

     *      ),
     *     path="/api/v1/tenant/{id}",
     *     tags={"Tenant"},
     *     summary="To get a particular tenant",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function getOne($id){

        try{
        $tenant = $this->tenant->getById($id);
        return response()->json($tenant, 201);

    } catch (\Throwable $ex) {

        return response()->json($ex->getMessage(), 400);
    }
    }

            /**
     * @OA\Patch  (

     *     path="/api/v1/tenant/{id}/status",
     *     tags={"Administrator"},
     *     summary="change the status of a tenant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Tenant Id",

     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/ChangeTenantStatus",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function changeState(ChangeTenant $request, $id){


        $data = [
            'IsActive' => $request->status
        ];
        try{
        $tenant = $this->tenant->update($id, $data);

        return response()->json($tenant, 201);

    } catch (\Throwable $ex) {

        return response()->json($ex->getMessage(), 400);
    }
    }
}
