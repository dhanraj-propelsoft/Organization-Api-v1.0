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
    protected $OrganizationService,$commonService;
    public function __construct(OrganizationService $OrganizationService,CommonService $commonService)
    {
        $this->OrganizationService = $OrganizationService;
        $this->commonService = $commonService;


    }


    public function tempOrganizationStore(Request $request)
    {

        Log::info('OrganizationController > tempOrganizationStore function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->tempOrganizationStore($request->all());
        Log::info('OrganizationController > tempOrganizationStore  function Return.' . json_encode($response));
        return $response;
    }
    public function organizationMasterDatas()
    {
        $response = $this->OrganizationService->organizationMasterDatas();
        Log::info('OrganizationController > organizationMasterDatas function Return.' . json_encode($response));
        return $response;
    }
    public function getCityByDistrictId(Request $request)
    {
        Log::info('OrganizationController > getCityByDistrictId function Inside.' . json_encode($request->all()));
        $response = $this->commonService->getCityByDistrictId($request->all());
        Log::info('OrganizationController > getCityByDistrictId function Return.' . json_encode($response));
        return $response;
    }
    public function getDistrictByStateId(Request $request)
    {
        Log::info('OrganizationController > getDistrictByStateId function Inside.' . json_encode($request->all()));
        $response = $this->commonService->getDistrictByStateId($request->all());
        Log::info('OrganizationController > getDistrictByStateId function Return.' . json_encode($response));
        return $response;
    }
    public function getOrganizationAccountByUid(Request $request)
    {
        Log::info('OrganizationController > getOrganizationAccountByUid function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->getOrganizationAccountByUid($request->all());
        Log::info('OrganizationController > getOrganizationAccountByUid function Return.' . json_encode($response));
        return $response;
    }
    public function setDefaultOrganization(Request $request)
    {
        Log::info('OrganizationController > setDefaultOrganization function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->setDefaultOrganization($request->all());
        Log::info('OrganizationController > setDefaultOrganization id function Return.' . json_encode($response));
        return $response;
    }
    public function organizationIndex(Request $request)
    {
        Log::info('OrganizationController > organizationIndex function Inside.' . json_encode($request->all()));
        $response = $this->OrganizationService->organizationIndex($request->all());
        Log::info('OrganizationController > organizationIndex function Return.' . json_encode($response));
        return $response;
    }

}
