<?php
namespace App\Http\Controllers\Api\Version_1\Repositories\Common;

use App\Http\Controllers\Api\Version_1\Interface\Common\CommonInterface;
use App\Models\BasicModels\State;
use App\Models\BasicModels\City;
use Illuminate\Support\Facades\Log;

class CommonRepository implements CommonInterface
 {

    public function getAllStates()
    {

        return State::whereNull('deleted_at')->get();
    }
    public function getCityByDistrictId($districtId)
    {
        return City::where('district_id', $districtId)->whereNull('deleted_at')->get()->toArray();

    }
}

