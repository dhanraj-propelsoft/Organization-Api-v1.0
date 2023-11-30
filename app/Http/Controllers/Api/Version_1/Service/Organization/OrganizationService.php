<?php

namespace App\Http\Controllers\Api\Version_1\Service\Organization;

use App\Http\Controllers\Api\Version_1\Interface\Common\CommonInterface;
use App\Http\Controllers\Api\Version_1\Interface\Organization\OrganizationInterface;
use App\Http\Controllers\Api\Version_1\Service\Common\CommonService;
use App\Models\Organization\TempOrganization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrganizationService
{
    protected $organizationInterface, $commonService, $commonInterface;

    public function __construct(OrganizationInterface $organizationInterface, CommonService $commonService, CommonInterface $commonInterface)
    {
        $this->organizationInterface = $organizationInterface;
        $this->commonService = $commonService;
        $this->commonInterface = $commonInterface;
    }
    public function tempOrganizationStore($datas)
    {

        $validator = Validator::make($datas, [
            'orgStructureId' => 'required',
            'orgCategoryId' => 'required',
            'orgOwnershipId' => 'required',
            'orgName' => 'required',
            'orgEmail' => 'required|email',
            'pinCode' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        } else {
            $datas = (object) $datas;

            $convertTempOrg = $this->convertTempOrganization($datas);
            $storeTempOrg = $this->organizationInterface->storeTempOrganization($convertTempOrg);
            return $this->commonService->sendResponse($storeTempOrg, true);
        }
    }
    public function convertTempOrganization($datas)
    {
        //  $uid = auth()->user()->uid;
        $uid = null;

        $orgDetail = [];
        $orgName = ($datas->orgName) ? $datas->orgName : null;
        $orgEmail = ($datas->orgEmail) ? $datas->orgEmail : null;
        $orgwebsite = isset($datas->orgWebsite) ? $datas->orgWebsite : null;
        $orgStructureId = isset($datas->orgStructureId) ? $datas->orgStructureId : null;
        $orgCategoryId = isset($datas->orgCategoryId) ? $datas->orgCategoryId : null;
        $orgOwnershipId = isset($datas->orgOwnershipId) ? $datas->orgOwnershipId : null;
        $orgDetail = [
            'orgName' => $orgName, 'orgEmail' => $orgEmail, 'orgwebsite' => $orgwebsite,
            'orgStructureId' => $orgStructureId, 'orgCategoryId' => $orgCategoryId, 'orgOwnershipId' => $orgOwnershipId
        ];
        $orgAddress = [];
        $doorNo = isset($datas->doorNo) ? $datas->doorNo : null;
        $buildingName = isset($datas->buildingName) ? $datas->buildingName : null;
        $street = isset($datas->street) ? $datas->street : null;
        $landMark = isset($datas->landMark) ? $datas->landMark : null;
        $pinCode = isset($datas->pinCode) ? $datas->pinCode : null;
        $districtId = isset($datas->districtId) ? $datas->districtId : null;
        $stateId = isset($datas->stateId) ? $datas->stateId : null;
        $CityId = isset($datas->cityId) ? $datas->cityId : null;
        $area = isset($datas->area) ? $datas->area : null;
        $location = isset($datas->location) ? $datas->location : null;
        $orgAddress = ['doorNo' => $doorNo, 'buildingName' => $buildingName, 'street' => $street, 'landMark' => $landMark, 'pinCode' => $pinCode, 'districtId' => $districtId, 'stateId' => $stateId, 'CityId' => $CityId, 'area' => $area, 'location' => $location];
        $orgDocModels = [];
        if (isset($datas->documentNo)) {

            for ($i = 0; $i < count($datas->documentNo); $i++) {
                if ($datas->documentNo[$i]) {

                    $doctypeId = $datas->orgDocTypeId[$i];
                    $docNo = $datas->documentNo[$i] ?? null;
                    $docValid = $datas->validDate[$i] ?? null;
                    if (isset($datas->fileAttachment[$i]) && $datas->fileAttachment[$i]) {
                        $uniqueFileName[$i] = date('YmdHis') . '_' . uniqid() . '.jpg';
                        $savePath[$i] = storage_path('app/public/OrganizationDocument/' . $uniqueFileName[$i]);
                        File::put($savePath[$i], $datas->fileAttachment[$i]);
                    }
                    $orgDocModel = ['doctypeId' => $doctypeId, 'docNo' => $docNo, 'docValid' => $docValid, 'docFilePath' => isset($uniqueFileName[$i]) ? $uniqueFileName[$i] : ''];

                    array_push($orgDocModels, $orgDocModel);
                }
            }
        }
        if (isset($datas->tempOrgId)) {
            $model = $this->organizationInterface->getTempOrganizationDataByTempId($datas->tempOrgId);
        } else {
            $model = new TempOrganization();
        }
        $model->authorized_person_id = $uid;
        $model->organization_detail = json_encode($orgDetail);
        $model->organization_address = json_encode($orgAddress);
        if ($orgDocModels) {
            $model->organization_doc_type = json_encode($orgDocModels);
        }
        return $model;
    }
    public function organizationMasterDatas()
    {

        // $uid = auth()->member()->uid;
        $uid = null;
        $state = $this->commonInterface->getAllStates();
        $orgStructure = $this->organizationInterface->pimsOrganizationStructure();
        $orgCategory = $this->organizationInterface->pimsOrganizationCategory();
        $orgOwnerShip = $this->organizationInterface->pimsOrganizationOwnerShip();
        $orgDocType = $this->organizationInterface->pimsOrganizationDocumentType();
        $result = ['state' => $state, 'orgStructure' => $orgStructure, 'orgCategory' => $orgCategory, 'orgOwnerShip' => $orgOwnerShip, 'orgDocType' => $orgDocType];
        return $this->commonService->sendResponse($result, true);
    }
    public function getOrganizationAccountByUid($uid)
    {
        Log::info('OrganizationService > getOrganizationAccountByUid function Inside.' . json_encode($uid));
        $OrganizationAccountModel = $this->organizationInterface->getOrganizationAccountByUid($uid);
        $transformed = $OrganizationAccountModel->map(function ($item) {
            $orgId = $item->organization_id;
            $defaultOrgStatus = $item->default_org;
            $pfmActiveStatus = $item->pfm_active_status_id;
            $orgName = $item->organizationDetail->org_name;
            return ['orgId' => $orgId, 'org_name' => $orgName, 'pfm_stage_id' => $pfmActiveStatus, 'default_org' => $defaultOrgStatus];
        });
        return $this->commonService->sendResponse($transformed, true);
    }
    public function setDefaultOrganization($datas)
    {

        $datas = (object) $datas;
        $model = $this->organizationInterface->changeDefaultOrganization($datas->uid);
        return $this->commonService->sendResponse($model, true);
    }
    public function organizationIndex()
    {
        // $uid = auth()->user()->uid;
        $uid = null;
        $orgName = $this->organizationInterface->getOrganizationName($uid);
        $mainOrganization = $orgName->map(function ($OrgItem) {
            $OrgId = $OrgItem->id;
            $orgName = $OrgItem->OrganizationDetail->org_name;
            return ['OrgName' => $orgName, 'OrgId' => $OrgId];
        });

        $tempOrg = $this->organizationInterface->getAllTempOrganizations($uid);
        $tempOrganization = $tempOrg->map(function ($tempOrgItem) {
            $tempOrgId = $tempOrgItem->id;
            $orgDetails = json_decode($tempOrgItem->organization_detail, true);
            return ['tempOrgName' => $orgDetails['orgName'], 'tempOrgId' => $tempOrgId];
        });

        $result = ['tempOrg' => $tempOrganization, 'mainOrg' => $mainOrganization];
        return $this->commonService->sendResponse($result, true);
    }
}
