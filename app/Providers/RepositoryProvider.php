<?php

namespace App\Providers;

use App\Interfaces\IOtpRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\OtpRepository;
use App\Interfaces\IStateRepository;
use App\Repositories\UserRepository;
use App\Interfaces\IDoctorRepository;
use App\Interfaces\IMemberRepository;
use App\Interfaces\IRatingRepository;
use App\Interfaces\ITenantRepository;
use App\Interfaces\IWalletRepository;
use App\Repositories\StateRepository;
use App\Interfaces\IBiodataRepository;
use App\Interfaces\ILabTestRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\MemberRepository;
use App\Repositories\RatingRepository;
use App\Repositories\TenantRepository;
use App\Repositories\WalletRepository;
use App\Interfaces\IActivityRepository;
use App\Interfaces\IDrugListRepository;
use App\Repositories\BiodataRepository;
use App\Repositories\LabTestRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ActivityRepository;

use App\Repositories\DrugListRepository;
use App\Interfaces\IBankdetailRepository;
use App\Interfaces\IWithdrawalRepository;
use App\Interfaces\IAppointmentRepository;
use App\Interfaces\ITransactionRepository;
use App\Repositories\BankdetailRepository;
use App\Repositories\WithdrawalRepository;
use App\Interfaces\INotificationRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\TransactionRepository;
use App\Interfaces\IPharmacyOrderRepository;
use App\Repositories\NotificationRepository;
use App\Interfaces\ILabTestRequestRepository;
use App\Interfaces\ISpecializationRepository;
use App\Interfaces\ISystemsettingsRepository;
use App\Repositories\PharmacyOrderRepository;
use App\Repositories\LabTestRequestRepository;
use App\Repositories\SpecializationRepository;
use App\Repositories\SystemsettingsRepository;
use App\Interfaces\IDrugPrescriptionRepository;
use App\Interfaces\IWalletTransactionRepository;
use App\Repositories\DrugPrescriptionRepository;
use App\Repositories\WalletTransactionRepository;
use App\Interfaces\IDrugprescriptionItemRepository;
use App\Repositories\DrugPrescriptionItemRepository;
use App\Interfaces\IAppointmentDiagnosisRepository;
use App\Interfaces\IDoctorSpecializationRepository;
use App\Interfaces\IScheduleRepository;
use App\Repositories\AppointmentDiagnosisRepository;
use App\Repositories\DoctorSpecializationRepository;
use App\Repositories\ScheduleRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IOtpRepository::class, OtpRepository::class);
        $this->app->bind(ISpecializationRepository::class, SpecializationRepository::class);
        $this->app->bind(IDoctorRepository::class, DoctorRepository::class);
        $this->app->bind(IWalletRepository::class, WalletRepository::class);
        $this->app->bind(IDoctorSpecializationRepository::class, DoctorSpecializationRepository::class);
        $this->app->bind(IAppointmentRepository::class, AppointmentRepository::class);
        $this->app->bind(ITenantRepository::class, TenantRepository::class);
        $this->app->bind(IMemberRepository::class, MemberRepository::class);
        $this->app->bind(ILabTestRepository::class, LabTestRepository::class);
        $this->app->bind(ILabTestRequestRepository::class, LabTestRequestRepository::class);
        $this->app->bind(INotificationRepository::class, NotificationRepository::class);
        $this->app->bind(IActivityRepository::class, ActivityRepository::class);
        $this->app->bind(IDrugListRepository::class, DrugListRepository::class);
        $this->app->bind(IRatingRepository::class, RatingRepository::class);
        $this->app->bind(IAppointmentDiagnosisRepository::class, AppointmentDiagnosisRepository::class);
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
        $this->app->bind(ISystemsettingsRepository::class, SystemsettingsRepository::class);
        $this->app->bind(IPharmacyOrderRepository::class, PharmacyOrderRepository::class);
        $this->app->bind(IBiodataRepository::class, BiodataRepository::class);
        $this->app->bind(IWalletTransactionRepository::class, WalletTransactionRepository::class);
        $this->app->bind(IWalletRepository::class, WalletRepository::class);
        $this->app->bind(IWithdrawalRepository::class, WithdrawalRepository::class);
        $this->app->bind(IBankdetailRepository::class, BankdetailRepository::class);
        $this->app->bind(IDrugPrescriptionRepository::class, DrugPrescriptionRepository::class);
        $this->app->bind(IStateRepository::class, StateRepository::class);
        $this->app->bind(IDrugprescriptionItemRepository::class, DrugprescriptionItemRepository::class);
        $this->app->bind(IScheduleRepository::class, ScheduleRepository::class);
    }
}
