<?php
use App\Http\Controllers\Api\Version_1\Controller\Organization\OrganizationDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Version_1\Controller\Organization\OrganizationController;


//dhana

// Route::middleware(['OnlyGateWay.access'])->group(function () {
    
    Route::post('tempOrganizationStore', [OrganizationController::class, 'tempOrganizationStore'])->name('tempOrganizationStore');
    Route::get('organizationMasterDatas', [OrganizationController::class, 'organizationMasterDatas'])->name('organizationMasterDatas');
    Route::post('getCityByDistrictId', [OrganizationController::class, 'getCityByDistrictId'])->name('getCityByDistrictId');
    Route::post('getDistrictByStateId', [OrganizationController::class, 'getDistrictByStateId'])->name('getDistrictByStateId');
    Route::post('getOrganizationAccountByUid', [OrganizationController::class, 'getOrganizationAccountByUid'])->name('getOrganizationAccountByUid');
    Route::post('setDefaultOrganization', [OrganizationController::class, 'setDefaultOrganization'])->name('setDefaultOrganization');
    Route::post('organizationIndex', [OrganizationController::class, 'organizationIndex'])->name('organizationIndex');

    Route::post('OrganizationPlanAndModules', [OrganizationDetailController::class, 'OrganizationPlanAndModules'])->name('OrganizationPlanAndModules');

// });
