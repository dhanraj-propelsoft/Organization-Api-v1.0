<?php

namespace App\Http\Controllers\Api\Version_1\Interface\Common;

interface commonInterface
{
    public function getAllStates();
    public function getCityByDistrictId($districtId);
    public function getDistrictByStateId($stateId);

}
