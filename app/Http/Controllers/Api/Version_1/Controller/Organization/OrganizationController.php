<?php

namespace App\Http\Controllers\Api\Version_1\Controller\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Api\Version_1\Service\Organization\OrganizationService;
use App\Http\Controllers\Api\Version_1\Service\Common\CommonService;

class OrganizationController extends Controller
{
    protected $OrganizationService, $commonService;
    public function __construct(OrganizationService $OrganizationService, CommonService $commonService)
    {
        $this->OrganizationService = $OrganizationService;
        $this->commonService = $commonService;
    }


    public function tempOrganizationStore(Request $request)
    {

        Log::info('OrganizationController > tempOrganizationStore function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->tempOrganizationStore($request->all());
        Log::info('OrganizationController > tempOrganizationStore  function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function organizationMasterDatas()
    {
        $response = $this->OrganizationService->organizationMasterDatas();
        Log::info('OrganizationController > organizationMasterDatas function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function getCityByDistrictId(Request $request)
    {
        Log::info('OrganizationController > getCityByDistrictId function Inside.' . json_encode($request->all()));
        $response = $this->commonService->getCityByDistrictId($request->all());
        Log::info('OrganizationController > getCityByDistrictId function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function getDistrictByStateId(Request $request)
    {
        Log::info('OrganizationController > getDistrictByStateId function Inside.' . json_encode($request->all()));
        $response = $this->commonService->getDistrictByStateId($request->all());
        Log::info('OrganizationController > getDistrictByStateId function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function getOrganizationAccountByUid(Request $request)
    {
        Log::info('OrganizationController > getOrganizationAccountByUid function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->getOrganizationAccountByUid($request->all());
        Log::info('OrganizationController > getOrganizationAccountByUid function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function setDefaultOrganization(Request $request)
    {
        Log::info('OrganizationController > setDefaultOrganization function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->setDefaultOrganization($request->all());
        Log::info('OrganizationController > setDefaultOrganization id function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
    public function organizationIndex(Request $request)
    {
        Log::info('OrganizationController > organizationIndex function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->organizationIndex($request->all());
        Log::info('OrganizationController > organizationIndex function Return.' . json_encode($response));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }

    public function getOrganizationDatabaseByOrgId($orgId)
    {
        $result = $this->commonInterface->getDataBaseNameByOrgId($orgId);
        Session::put('currentDatabase', $result->db_name);
        Config::set('database.connections.mysql_external.database', $result->db_name);
        DB::purge('mysql');
        DB::reconnect('mysql');
        Log::info('CommonService > getOrganizationDatabaseByOrgId function Return.' . json_encode($result));
        if ($response['status']) {
            return $this->commonService->sendResponse($response, true);
        } else {
            return $this->commonService->sendError($response, false);
        }
    }
}
