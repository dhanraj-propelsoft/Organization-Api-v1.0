<?php

namespace App\Http\Controllers\Api\Version_1\Controller\Organization;

use App\Http\Controllers\Api\Version_1\Service\Common\CommonService;
use App\Http\Controllers\Controller;

use App\Models\PimsMenu;
use App\Models\PimsMenuFunction;
use App\Models\PimsModule;
use App\Models\PimsPackageApplicable;
use App\Models\PimsPlan;
use App\Models\PimsPlanApplicapable;
use App\Models\PimsSubscription;
use Illuminate\Http\Request;
use Log;

class OrganizationDetailController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {

        $this->commonService = $commonService;

    }
    public function OrganizationPlanAndModules()
    {

        $modules = PimsSubscription::where('org_id', 2)->first();
        $planId = $modules->plan_id;
        $packageApplicableId = PimsPlan::where('id', $planId)->first()->package_applicapable_id;
        $packageApplicapableModule = PimsPackageApplicable::where('id', $packageApplicableId)->first()->module_id;
        $ModuleArray = json_decode($packageApplicapableModule, true);

        $defaulDatas = [];
        // $defaulDatas['module_name'] = [];

        $organizedData = [];

        for ($i = 0; $i < count($ModuleArray); $i++) {
            $moduleId = $ModuleArray[$i];
            $moduleName = PimsModule::where('id', $moduleId)->first()->display_name;

            $moduleData = [
                'moduleName' => $moduleName,
                'menus' => []
            ];

            $PlanApplicapable = PimsPlanApplicapable::with([
                'menu' => function ($query) use ($moduleId) {
                    $query->where('module_id', $moduleId);
                }
            ])->where('plan_id', $planId)->get();

            $menuDataArray = [];

            for ($j = 0; $j < count($PlanApplicapable); $j++) {
                $menuId = $PlanApplicapable[$j]->menu_id;
                $MenuName = PimsMenu::where('id', $menuId)->first()->menu_name;

                // Initialize the menu item with its name and an empty functions array
                $menuData = [
                    'menuName' => $MenuName,
                    'menuFunctions' => []
                ];

                $menuFunctionIds = $PlanApplicapable[$j]->menu_function_id;
                $MenuFunctionIdArray = json_decode($menuFunctionIds, true);

                for ($k = 0; $k < count($MenuFunctionIdArray); $k++) {
                    $mfId = $MenuFunctionIdArray[$k];
                    $menuFunctionname = PimsMenuFunction::where('id', $mfId)->first()->function_name;

                    $menuFunctionData = [
                        'functionName' => $menuFunctionname
                        // You can add more data here if needed
                    ];
                  
                    $menuData['menuFunctions'][] = $menuFunctionData;
                }


                $moduleData['menus'][] = $menuData;

            }

            // Debug the result
            $organizedData[] = $moduleData;

        }
        return response()->json($organizedData);
    }
}
