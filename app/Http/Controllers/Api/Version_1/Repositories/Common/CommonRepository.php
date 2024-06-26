<?php
namespace App\Http\Controllers\Api\Version_1\Repositories\Common;

use App\Http\Controllers\Api\Version_1\Interface\Common\CommonInterface;
use App\Models\BasicModels\State;
use App\Models\BasicModels\City;
use App\Models\BasicModels\District;
use App\Models\Organization\OrganizationDatabase;
use Illuminate\Support\Facades\Log;

class CommonRepository implements CommonInterface
 {

    public function getAllStates()
    {

        return State::whereNull('deleted_at')->get();
    }
    public function getCityByDistrictId($districtId)
    {
        return City::where('district_id', $districtId)->whereNull('deleted_flag')->get()->toArray();

    }
    public function getDistrictByStateId($stateId)
    {
        return District::where('state_id', $stateId)->whereNull('deleted_flag')->get()->toArray();

    }

    public function getDataBaseNameByOrgId($orgId)
    {
        return OrganizationDatabase::where('org_id', $orgId)->first();


    }
}

