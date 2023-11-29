<?php

namespace App\Http\Controllers\Api\Version_1\Service\Common;


use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\Version_1\Interface\Common\CommonInterface;

class CommonService
{
    public function __construct(commonInterface $commonInterface)
    {
      $this->commonInterface = $commonInterface;

    }
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
    public function sendError($errorMessages = [], $error, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
    public function getAllStates()
    {
        $result = $this->commonInterface->getAllStates();
        Log::info('CommonService > getAllStates function Return.' . json_encode($result));
        return $this->sendResponse($result, true);
    }
    public function getCityByDistrictId($data)
    {
      Log::info('CommonService > getCityByDistrictId function Inside.' . json_encode($data));
      $result = $this->commonInterface->getCityByDistrictId($data['districtId']);
      Log::info('CommonService > getCityByDistrictId function Return.' . json_encode($result));
      return $this->sendResponse($result, true);
    }
    public function getDistrictByStateId($data)
    {
      Log::info('CommonService > getDistrictByStateId function Inside.' . json_encode($data));
      $result = $this->commonInterface->getDistrictByStateId($data['stateId']);
      Log::info('CommonService > getDistrictByStateId function Return.' . json_encode($result));
      return $this->sendResponse($result, true);
    }
}
