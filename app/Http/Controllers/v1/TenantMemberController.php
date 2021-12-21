<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Interfaces\IUserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest\CreateMemberRequest;
use App\Interfaces\IMemberRepository;
use App\Interfaces\ITenantRepository;

class TenantMemberController extends Controller
{
    private $user;
    private $member;
    private $tenant;

    public function __construct(IUserRepository $user, IMemberRepository $member, ITenantRepository $tenant)
    {
        $this->user = $user;
        $this->member = $member;
        $this->tenant = $tenant;
    }


     /**
     * @OA\Post  (

     *     path="/api/v1/tenant/member/create",
     *     tags={"TenantMember"},
     *     summary="register a Tenant Member",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/CreateMemberRequest",
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function addMember(CreateMemberRequest $request){
        $userdata = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phonenumber' => $request->phonenumber,
            'email' => $request->email,
            'password' => $request->password,
            'roles_id' => $request->roles_id,
            'state_id' => $request->state_id,
            'gender' => $request->gender,

        ];

        $user = $this->user->add($userdata);
        $memberdata = [
            'tenant_id' => $request->tenant_id,
            'tenant_role_id' => $request->tenant_role_id,
            'user_id' => $user->id
        ];
        try{
            $member = $this->member->add($memberdata);

        if($member){
            return response()->json($user, 201);
        }else{
            return response()->json(401);
        }
        }catch(\Throwable $ex) {

            return response()->json($ex->getMessage(), 400);
        }
    }


         /**
     * @OA\Get  (
    *     @OA\Parameter(
     *         name="id",
     *         in="path",
     * required=true,

     *         description="Tenant id",

     *      ),
     *     path="/api/v1/tenant/{id}/members",
     *     tags={"TenantMember"},
     *     summary="To get the members of a tenant",

     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function viewMembers($id){
        $members =  $this->tenant->querable()->where('id', $id)->with('tenantMember.user')->get();
        if($members != null){
            return response()->json($members, 201);
        }else{
            $response = "Tenant not Found";
            return response()->json($response, 400);
        }
    }

     /**
     * @OA\Get(
     *      path="/api/v1/tenantmember/{user_id}",
     *      operationId="getByUserId",
     *      tags={"TenantMember"},
     *      summary="Get tenant member by user id",
     *      description="Returns all tenant member with the specified user id",
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
    public function getByUserId($id){
        $members = $this->member->querable()->where('user_id', $id)->with('user')->with('tenant.tenanttype')->with('tenant_role')->first();
        return response()->json($members, 200);
    }
}
