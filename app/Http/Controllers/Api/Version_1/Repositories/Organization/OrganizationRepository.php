<?php

namespace App\Http\Controllers\Api\Version_1\Repositories\Organization;

use App\Http\Controllers\Api\Version_1\Interface\Organization\OrganizationInterface;
use App\Models\Organization\TempOrganization;
use App\Models\Organization\Organization;
use App\Models\Organization\UserOrganizationRelational;
use App\Models\PIMSOrganization\Category;
use App\Models\PIMSOrganization\DocumentType;
use App\Models\PIMSOrganization\OwnerShip;
use App\Models\PIMSOrganization\Structure;
use Illuminate\Support\Facades\DB;

class OrganizationRepository implements OrganizationInterface
{
    public function getTempOrganizationDataByTempId($tempOrgId)
    {
        return TempOrganization::where('id', $tempOrgId)->whereNull('deleted_at')->first();
    }
    public function storeTempOrganization($model)
    {
        try {
            $result = DB::transaction(function () use ($model) {

                $model->save();
                return [
                    'message' => "Success",
                    'data' => $model,
                ];
            });

            return $result;
        } catch (\Exception $e) {

            return [

                'message' => "failed",
                'data' => $e,
            ];
        }
    }
    public function pimsOrganizationStructure()
    {
        return Structure::whereNull('deleted_flag')
            ->whereNull('deleted_at')
            ->get();

    }
    public function pimsOrganizationCategory()
    {
        return Category::whereNull('deleted_flag')
            ->whereNull('deleted_at')
            ->get();

    }
    public function pimsOrganizationOwnerShip()
    {
        return OwnerShip::whereNull('deleted_flag')
            ->whereNull('deleted_at')
            ->get();

    }
    public function pimsOrganizationDocumentType()
    {
        return DocumentType::whereNull('deleted_flag')
            ->whereNull('deleted_at')
            ->get();

    }
    public function getOrganizationAccountByUid($uid)
    {
        return UserOrganizationRelational::with('organizationDetail')->where('uid', $uid)->whereNull('deleted_flag')->get();
    }
    public function changeDefaultOrganization($uid)
    {
        $org = UserOrganizationRelational::where(['uid' => $uid, ['default_org', '=', '1']])->first();
        if ($org) {
            UserOrganizationRelational::updateOrInsert(
                ['uid' => $uid, 'default_org' => 1],
                ['default_org' => 0]
            );
            return $org;
        }
        return false;
    }
    public function getOrganizationName($uid)
    {
        return Organization::with('OrganizationDetail', 'userRelational')
            ->where('pfm_stage_id', 1)
            ->whereNull('deleted_flag')
            ->whereHas('userRelational', function ($query) use ($uid) {
                $query->where('uid', $uid);
            })->get();

    }
    public function getAllTempOrganizations($uid)
    {
        return TempOrganization::where('authorized_person_id', $uid)->whereNull('deleted_flag')
            ->get();
    }

}
