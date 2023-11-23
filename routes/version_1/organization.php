<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Version_1\Controller\Organization\OrganizationController;

Route::post('tempOrganizationStore', [OrganizationController::class,'tempOrganizationStore'])->name('tempOrganizationStore');
Route::get('organizationMasterDatas', [OrganizationController::class,'organizationMasterDatas'])->name('organizationMasterDatas');
Route::post('getCityByDistrictId', [OrganizationController::class,'getCityByDistrictId'])->name('getCityByDistrictId');
Route::post('getOrganizationAccountByUid', [OrganizationController::class,'getOrganizationAccountByUid'])->name('getOrganizationAccountByUid');
Route::post('setDefaultOrganization', [OrganizationController::class,'setDefaultOrganization'])->name('setDefaultOrganization');
Route::get('organizationIndex', [OrganizationController::class,'organizationIndex'])->name('organizationIndex');
