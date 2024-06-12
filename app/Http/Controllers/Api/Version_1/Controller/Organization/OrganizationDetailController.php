<?php

namespace App\Http\Controllers\Api\Version_1\Controller\Organization;

use App\Http\Controllers\Controller;

use App\Models\PimsMenu;
use App\Models\PimsMenuFunction;
use App\Models\PimsModule;
use App\Models\PimsPackageApplicable;
use App\Models\PimsPlan;
use App\Models\PimsPlanApplicapable;
use App\Models\PimsSubscription;
use Illuminate\Http\Request;

class OrganizationDetailController extends Controller
{
    public function OrganizationPlanAndModules()
    {

        $modules = PimsSubscription::where('org_id', 1)->first();
        $planId = $modules->plan_id;

     

        $packageApplicableId = PimsPlan::where('id', $planId)->first()->package_applicapable_id;
        $packageApplicapableModule = PimsPackageApplicable::where('id', $packageApplicableId)->first()->module_id;
        $ModuleArray = json_decode($packageApplicapableModule, true);
        $defaulDatas = [];
        for ($i = 0; $i < count($ModuleArray); $i++) {
            $moduleId = $ModuleArray[$i];
            $moduleName = PimsModule::where('id', $moduleId)->first()->display_name;
            $PlanApplicapable = PimsPlanApplicapable::where('id', $planId)->get();
            $AllModuleAndMenuFunctionArray = [];
            for ($j = 0; $j < count($PlanApplicapable); $j++) {
                $menuModule = PimsMenu::where('id', $PlanApplicapable[$j]->menu_id)->first()->menu_name;

                $menufunctionIds = $PlanApplicapable[$j]->menu_function_id;
                $MenuFunctionArray = json_decode($menufunctionIds, true);
                $AllMenuFunctionArray = [];
                for ($k = 0; $k < count($MenuFunctionArray); $k++) {
                    $menufunctionId = $MenuFunctionArray[$k];

                    $menuFunctionModule = PimsMenuFunction::where('id', $menufunctionId)->first()->function_name;
                    array_push($AllMenuFunctionArray, $menuFunctionModule);
                }
                $returnModAndMenu = ['menu' => $menuModule, 'menufunction' => $AllMenuFunctionArray];
                array_push($AllModuleAndMenuFunctionArray, $returnModAndMenu);
            }

            $returnModAndMenuAndMenuFunction = ['moduleName' => $moduleName, 'AllModuleAndMenuFunctionArray' => $AllModuleAndMenuFunctionArray];
            array_push($defaulDatas, $returnModAndMenuAndMenuFunction);
        }
        dd($defaulDatas);
        return response()->json($defaulDatas);
    }
}
