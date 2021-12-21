<?php

use App\Models\Appointment;
use App\Models\LabtestRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\StateController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\AdminController;
use App\Http\Controllers\v1\DoctorController;
use App\Http\Controllers\v1\RatingController;
use App\Http\Controllers\v1\TenantController;
use App\Http\Controllers\v1\WalletController;
use App\Http\Controllers\v1\BiodataController;
use App\Http\Controllers\v1\LabtestController;
use App\Http\Controllers\v1\PaymentController;
use App\Http\Controllers\v1\ActivityController;
use App\Http\Controllers\v1\DrugListController;
use App\Http\Controllers\v1\BankdetailController;
use App\Http\Controllers\v1\AppointmentController;
use App\Http\Controllers\v1\TransactionController;
use App\Http\Controllers\v1\WithdrawalsController;
use App\Http\Controllers\v1\NotificationController;
use App\Http\Controllers\v1\TenantMemberController;
use App\Http\Controllers\v1\PharmacyOrderController;
use App\Http\Controllers\v1\LabtestRequestController;
use App\Http\Controllers\v1\SpecializationController;
use App\Http\Controllers\v1\ApplicationDataController;
use App\Http\Controllers\v1\DrugPrescriptionController;
use App\Http\Controllers\v1\WalletTransactionController;
use App\Http\Controllers\v1\DoctorSpecializationController;
use App\Http\Controllers\v1\DrugprescriptionItemController;

Route::get('/v1/doctordetail/{id}', [DoctorController::class, 'getdoctor']);
Route::get('/v1/doctordetail/user/{id}', [DoctorController::class, 'getdoctoruserId']);
Route::get('/v1/tenantmember/{user_id}', [TenantMemberController::class, 'getByUserId']);
Route::get('/v1/doctorsearch', [DoctorSpecializationController::class, 'getdoctorbysearch']);
Route::get('/v1/getallappointmentstatus', [ApplicationDataController::class, 'getallappointmentstatus']);
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);
Route::get('/v1/users', [AuthController::class, 'getallusers']);
Route::get('/v1/doctors', [DoctorController::class, 'getalldoctors']);
Route::get('/v1/specialization', [SpecializationController::class, 'getallspecializations']);
Route::post('/v1/verify', [AuthController::class, 'verify']);
Route::post('/v1/resend-otp', [AuthController::class, 'resend']);
Route::post('/v1/verifyforgotpassword', [AuthController::class, 'verifyforgotpassword']);
Route::post('/v1/forgotpassword', [AuthController::class, 'forgotpassword']);
Route::get('/v1/getallavailability', [ApplicationDataController::class, 'getallavailabilty']);
Route::post('/v1/appointment/customer/checkavailability', [AppointmentController::class, 'checkavailability']);
Route::get('/v1/activity/get/{id}', [ActivityController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/v1/userinfo', [AuthController::class, 'getuser']);
    Route::get('/v1/patient/detailscount/{id}', [AuthController::class, 'detailscount']);
    Route::patch('/v1/updateuser', [AuthController::class, 'updateuser']);
    Route::post('/v1/changepassword', [AuthController::class, 'changepassword']);
    //Finance
    Route::get('/v1/getwallet-detail', [WalletController::class, 'getwalletdetail']);
    //Doctors Route
    Route::patch('/v1/updatedoctor', [DoctorController::class, 'updatedoctor']);
    Route::post('/v1/doctorspecialization/create', [DoctorSpecializationController::class, 'register']);
    Route::get('/v1/doctor/specialization/{id}', [DoctorSpecializationController::class, 'doctorspecialization']);

    Route::post('/v1/doctor/create', [DoctorController::class, 'register']);
    Route::patch('/v1/doctor/changestate/{id}', [DoctorController::class, 'adminchangestate']);
    Route::get('/v1/doctor/detailscount/{id}', [DoctorController::class, 'detailscount']);
    Route::get('/v1/doctor/account/{id}', [DoctorController::class, 'account']);
  //  Route::post('/v1/doctor/schedule/', [DoctorController::class, 'register']);


   // Route::get('/v1/doctordetail/{id}', [DoctorController::class, 'getdoctor']);
    // Route::get('/v1/doctordetail/user/{id}', [DoctorController::class, 'getdoctoruser']);
    //Appointment Route


    Route::post('/v1/appointment/customer/create', [AppointmentController::class, 'addappointmentbycustomer']);
    Route::patch('/v1/appointment/changestatus/{id}', [AppointmentController::class, 'acceptordecline']);
    Route::get('/v1/appointment/doctor/{id}', [AppointmentController::class, 'doctorappointments']);
    Route::get('/v1/appointment/customer/{id}', [AppointmentController::class, 'customerappointments']);
    Route::get('/v1/appointment/customer/single/{id}', [AppointmentController::class, 'customerappointment']);
    Route::get('/v1/appointment/checktime/{id}', [AppointmentController::class, 'checkappointmentdate']);
    Route::patch('/v1/appointment/update/{id}', [AppointmentController::class, 'updateappointment']);
    Route::post('/v1/appointment/diagnosis/create', [AppointmentController::class, 'addappointmentdiagnosis']);
    Route::get('/v1/appointment/getbyid/{id}', [AppointmentController::class, 'getAppointmentById']);

    Route::get('/v1/lastappointment/user/{id}', [AppointmentController::class, 'getUserLastAppointment']);

    ///administrator
    Route::get('/v1/administrator/summary', [AdminController::class, 'summary']);
    Route::get('/v1/administrator/appointments', [AdminController::class, 'getappointments']);
    Route::post('/v1/adminstrator/appointmentfee/update', [AdminController::class, 'setfee']);
    Route::get('/v1/adminstrator/appointmentfee', [AdminController::class, 'getfee']);


    //specialization
    Route::post('/v1/specialization/create', [SpecializationController::class, 'register']);
    Route::patch('/v1/specialization/changestate/{id}', [SpecializationController::class, 'adminchangestate']);
    Route::get('/v1/specializationdetail/{id}', [SpecializationController::class, 'getspecialization']);
    //notification
    Route::post('/v1/notification/add', [NotificationController::class, 'store']);
    Route::get('/v1/notification/get/{id}', [NotificationController::class, 'show']);

    //activity
    Route::post('/v1/activity/add', [ActivityController::class, 'store']);


    //pharmacy order
    Route::get('/v1/pharmacyorder/tenant', [PharmacyOrderController::class, 'getByTenantId']);
    Route::patch('/v1/pharmacyorder/complete/{id}', [PharmacyOrderController::class, 'completeOrder']);

    //tenancy
    Route::post('/v1/tenant/create', [TenantController::class, 'create']);
    Route::get('/v1/tenants', [TenantController::class, 'getAll']);
    Route::get('/v1/tenant/{id}', [TenantController::class, 'getOne']);
    Route::patch('/v1/tenant/{id}/status', [TenantController::class, 'changeState'])->middleware('admin');
    Route::post('/v1/tenant/member/create', [TenantMemberController::class, 'addMember']);
    Route::get('/v1/tenant/{id}/members', [TenantMemberController::class, 'viewMembers']);
    //end tanancy

    //drug prescription
    Route::post('/v1/drug/prescribe', [DrugprescriptionItemController::class, 'store']);
    Route::post('/v1/drug/prescription-item/delete/{id}', [DrugprescriptionItemController::class, 'delete']);
    Route::post('/v1/drug/delivery/{id}', [DrugPrescriptionController::class, 'setDeliveryType']);
    Route::get('/v1/prescriptions/appointment/{id}', [AppointmentController::class, 'getDrugprescription']);

    // doctor rating endpoint
    Route::get('/v1/doctor/rating/{id}', [RatingController::class, 'show']);
    Route::post('/v1/doctor/rate/{id}', [RatingController::class, 'store']);


    //Wallet Transaction
    Route::post('/v1/wallet-tx/add', [WalletTransactionController::class, 'create']);

    //Transaction
    Route::get('/v1/transactions/all', [TransactionController::class, 'index']);
    Route::get('/v1/transactions/byid/{id}', [TransactionController::class, 'getById']);

    //Pharmacy request
    Route::get('/v1/pharmacy/request/all', [PharmacyOrderController::class, 'index']);

    //drug list
    Route::post('/v1/drug/add', [DrugListController::class, 'store']);
    Route::get('/v1/drugs/all', [DrugListController::class, 'index']);
    Route::get('/v1/drugs/byname', [DrugListController::class, 'getByName']);
    Route::get('/v1/drugs/byid', [DrugListController::class, 'getById']);
    Route::get('/v1/drug/change-status/{id}', [DrugListController::class, 'changeState']);
    Route::post('/v1/biodata/add', [BiodataController::class, 'store']);
    Route::get('/v1/biodata/byid', [BiodataController::class, 'getById']);
    Route::post('/v1/biodata/update/{id}', [BiodataController::class, 'edit']);


    //Lab test
    Route::post('/v1/labtest/add', [LabtestController::class, 'store']);
    Route::get('/v1/user/labtest/{id}', [LabtestController::class, 'getPatientTests']);
    Route::get('/v1/doctor/labtest/{id}', [LabtestController::class, 'getDoctorTestsRequests']);
    Route::patch('/v1/doctor/labtest/complete/{id}', [LabtestController::class, 'complete']);
    Route::patch('/v1/lab/external/{id}', [LabtestController::class, 'isExternalLabTrue']);
    Route::patch('/v1/lab/internal/{id}', [LabtestController::class, 'isExternalLabFalse']);
    Route::get('/v1/labtests', [LabtestController::class, 'getLabTests']);

    //end Lab Test

    //Lab Test Request
    Route::post('/v1/labtestrequest/add', [LabtestRequestController::class, 'store']);
    Route::get('/v1/labtestrequests', [LabtestRequestController::class, 'getLabTestRequests']);
    //End Lab Test


    Route::post('/v1/notification/add', [NotificationController::class, 'store']);
    Route::get('/v1/notification/get/{id}', [NotificationController::class, 'show']);


    //activity
    Route::post('/v1/activity/add', [ActivityController::class, 'store']);


    //tenancy
    Route::post('/v1/tenant/create', [TenantController::class, 'create']);
    Route::get('/v1/tenants', [TenantController::class, 'getAll']);
    Route::get('/v1/tenant/{id}', [TenantController::class, 'getOne']);
    Route::patch('/v1/tenant/{id}/status', [TenantController::class, 'changeState'])->middleware('admin');
    Route::post('/v1/tenant/member/create', [TenantMemberController::class, 'addMember']);
    Route::get('/v1/tenant/{id}/members', [TenantMemberController::class, 'viewMembers']);


//wallet
Route::post('/v1/wallet/credit/{user_id}', [WalletController::class, 'creditWallet']);
Route::post('/v1/wallet/withdraw', [WithdrawalsController::class, 'withdraw']);
Route::get('/v1/wallet/withdrawals', [WithdrawalsController::class, 'getwithdrawals']);
Route::get('/v1/wallet/withdrawals/{id}', [WithdrawalsController::class, 'getwithdrawalsbyuserid']);
Route::get('/v1/wallet/withdraw/{id}', [WithdrawalsController::class, 'getwithdrawalbyid']);

Route::get('/v1/wallet/getwallet-detail', [WithdrawalsController::class, 'getwalletdetail']);
Route::patch('/v1/wallet/withdraw/{id}', [WithdrawalsController::class, 'updatewithdrawal']);


///





    //end tanancy


    //Lab test
    Route::post('/v1/labtest/add', [LabtestController::class, 'store']);
    Route::get('/v1/user/labtest/{id}', [LabtestController::class, 'getPatientTests']);
    Route::get('/v1/doctor/labtest/{id}', [LabtestController::class, 'getDoctorTestsRequests']);
    Route::patch('/v1/lab/external/{id}', [LabtestController::class, 'isExternalLabTrue']);
    Route::patch('/v1/lab/internal/{id}', [LabtestController::class, 'isExternalLabFalse']);
    Route::get('/v1/labtests', [LabtestController::class, 'getLabTests']);
    Route::get('/v1/getl Dabtestbyappointmentid/{id}', [LabtestController::class, 'getLabTestByAppointmentId']);
    Route::patch('/v1/updateresult/labtest/{id}', [LabtestController::class, 'updateResult']);

    //Lab Test Request
    Route::post('/v1/labtestrequest/add', [LabtestRequestController::class, 'store']);
    Route::get('/v1/labtestrequests', [LabtestRequestController::class, 'getLabTestRequests']);

    Route::patch('/v1/isdoctorended/{id}', [LabtestController::class, 'isDoctorEnded']);
    Route::patch('/v1/appointment/labtest/skip/{id}', [AppointmentController::class, 'skipTest']);
    Route::get('/v1/getlabtestbyappointmentid/{id}', [LabtestController::class, 'getLabTestByAppointmentId']);
    Route::patch('/v1/labtestrequest/result/{labtest_id}', [LabtestRequestController::class, 'postResult']);

    Route::get('/v1/labtestrequest/tenant', [LabtestRequestController::class, 'getLabTestRequestByTenantId']);
    //drug prescription
    Route::post('/v1/drug/prescribe', [DrugprescriptionItemController::class, 'store']);
    Route::post('/v1/drug/delivery/{id}', [DrugPrescriptionController::class, 'setDeliveryType']);
    Route::get('/v1/drug/prescription/byappointment', [DrugPrescriptionController::class, 'getByAppointmentId']);
    Route::get('/v1/prescriptions/appointment/{id}', [AppointmentController::class, 'getDrugprescription']);
    Route::get('/v1/prescriptions/byprescriptionid', [DrugprescriptionItemController::class, 'getByPrescriptionId']);

    // doctor rating endpoint

    Route::post('/v1/doctor/rate/{id}', [RatingController::class, 'store']);

    //wallet
    Route::post('/v1/wallet/credit/{user_id}', [WalletController::class, 'creditWallet']);


    //Wallet Transaction
    Route::post('/v1/wallet-tx/add', [WalletTransactionController::class, 'create']);
    Route::get('/v1/wallet-tx/all', [WalletTransactionController::class, 'index']);
    Route::get('/v1/wallet-tx/byid', [WalletTransactionController::class, 'getById']);

    //Pharmacy request
    Route::get('/v1/pharmacy/request/all', [PharmacyOrderController::class, 'index']);

    //bio data
    Route::post('/v1/biodata/add', [BiodataController::class, 'store']);
    Route::get('/v1/biodata/byid', [BiodataController::class, 'getById']);

    //bank detail
    Route::post('/v1/bank-detail/add', [BankdetailController::class, 'create']);
    Route::get('/v1/bank-detail/byid', [BankdetailController::class, 'getById']);
});


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/v1/logout', [AuthController::class, 'logout']);
});

Route::get('/v1/doctor/rating/{id}', [RatingController::class, 'show']);
Route::post('/v1/paystack/confirmtransfer', [WithdrawalsController::class, 'confirmation']);


Route::get('/v1/get/user/{id}', [AuthController::class, 'getSingleUser']);

//States
Route::get('/v1/states/all', [StateController::class, 'index']);



