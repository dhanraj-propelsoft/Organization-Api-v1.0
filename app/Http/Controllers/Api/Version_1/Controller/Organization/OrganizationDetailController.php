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
use App\Models\POC\MemberMenuFunctionPermissionPoc;
use App\Models\POC\MemberMenuPermissionPoc;
use App\Models\POC\MemberModulePermissionPoc;
use App\Models\POC\MemberRolesPoc;
use Illuminate\Http\Request;
use Log;

class OrganizationDetailController extends Controller
{
    protected $commonService;

    public function __construct(CommonService $commonService)
    {

        $this->commonService = $commonService;

    }
    public function getOrganiationPlanBasedModules(Request $request)
    {
        $uid = $request->get("uid");
        $orgId = $request->get('orgId');

        $getSubscriptionModule = PimsSubscription::where('org_id', $orgId)->first();

        $planId = $getSubscriptionModule->plan_id;

        $packageApplicableId = PimsPlan::where('id', $planId)->first()->package_applicapable_id;

        $packageApplicapableModule = PimsPackageApplicable::where('id', $packageApplicableId)->first()->module_id;

        $ModuleArray = json_decode($packageApplicapableModule, true);




        $organizedData = [];

        for ($i = 0; $i < count($ModuleArray); $i++) {

            $moduleId = $ModuleArray[$i];

            $moduleName = PimsModule::where('id', $moduleId)->first();

            $moduleData = [
                'moduleId' => $moduleName->id,
                'moduleName' => $moduleName->display_name,
                'moduleIcon' => $moduleName->icon_data,
            ];
            $organizedData[] = $moduleData;
        }
        return response()->json($organizedData);

    }
    public function getmemberMenusAndFunctionByModuleId(Request $request)
    {



        $uid = $request->get("uid");
        $orgId = $request->get('orgId');
        $moduleId = $request->get('moduleId');


        $organizedData = [];



        $moduleName = PimsModule::where('id', $moduleId)->first();

        $connectDb = $this->commonService->getOrganizationDatabaseByOrgId($orgId);

        $getLoginedMemberRoleId = MemberRolesPoc::where('uid', $uid)->first()->role_id;

        $getMembermenuModule = MemberMenuPermissionPoc::where('role_id', $getLoginedMemberRoleId)->first()->menu_id;
        $memberMenuModuleArray = json_decode($getMembermenuModule, true);

     

        $organizedData = [];
        for ($j = 0; $j < count($memberMenuModuleArray); $j++) {


            $menuId = $memberMenuModuleArray[$j];
            $MenuName = PimsMenu::where('id', $menuId)->first()->menu_name;

            $getMembermenuFunctionModule = MemberMenuFunctionPermissionPoc::where('role_id', $getLoginedMemberRoleId)
                ->where('menu_id', $menuId)
                ->first()->menu_function_id;

            $memberMenuFunctionModuleArray = json_decode($getMembermenuFunctionModule, true);



            // Initialize the menu item with its name and an empty functions array
            $menuData = [
                'menuName' => $MenuName,
                'menuFunctions' => []
            ];


            for ($k = 0; $k < count($memberMenuFunctionModuleArray); $k++) {
                $mfId = $memberMenuFunctionModuleArray[$k];

                $menuFunctionname = PimsMenuFunction::where('id', $mfId)->first()->function_name;

                $menuFunctionData = [
                    'functionName' => $menuFunctionname
                    // You can add more data here if needed
                ];

                $menuData['menuFunctions'][] = $menuFunctionData;
            }


            $moduleData['menus'][] = $menuData;

            $organizedData[] = $moduleData;
        }
        return response()->json($organizedData);
    }
    public function OrganizationPlanAndModules(Request $request)
    {


        $uid = $request->get("uid");
        $orgId = $request->get('orgId');

        $connectDb = $this->commonService->getOrganizationDatabaseByOrgId($orgId);

        $getLoginedMemberRoleId = MemberRolesPoc::where('uid', $uid)->first()->role_id;

        $getMemberModules = MemberModulePermissionPoc::where('role_id', $getLoginedMemberRoleId)->first()->module_id;
        $getMemberModuleArray = json_decode($getMemberModules, true);

        $modules = PimsSubscription::where('org_id', $orgId)->first();

        $planId = $modules->plan_id;

        $packageApplicableId = PimsPlan::where('id', $planId)->first()->package_applicapable_id;

        $packageApplicapableModule = PimsPackageApplicable::where('id', $packageApplicableId)->first()->module_id;

        $ModuleArray = json_decode($packageApplicapableModule, true);

        $ModuleIntersections = array_intersect($ModuleArray, $getMemberModuleArray);


        $defaulDatas = [];
        // $defaulDatas['module_name'] = [];

        $organizedData = [];

        for ($i = 0; $i < count($ModuleIntersections); $i++) {

            $moduleId = $ModuleIntersections[$i];

            $moduleName = PimsModule::where('id', $moduleId)->first();

            $moduleData = [
                'moduleName' => $moduleName->display_name,
                'moduleIcon' => $moduleName->icon_data,
                'menus' => []
            ];


            $getMembermenuModule = MemberMenuPermissionPoc::where('role_id', $getLoginedMemberRoleId)->first()->menu_id;
            $memberMenuModuleArray = json_decode($getMembermenuModule, true);




            // $PlanApplicapable = PimsPlanApplicapable::with([
            //     'menu' => function ($query) use ($moduleId) {
            //         $query->where('module_id', $moduleId);
            //     }
            // ])
            //     ->where('plan_id', $planId)
            //     ->whereIn('menu_id', $memberMenuModuleArray)
            //     ->get();

            $menuDataArray = [];

            for ($j = 0; $j < count($memberMenuModuleArray); $j++) {


                $menuId = $memberMenuModuleArray[$j];
                $MenuName = PimsMenu::where('id', $menuId)->first()->menu_name;

                $getMembermenuFunctionModule = MemberMenuFunctionPermissionPoc::where('role_id', $getLoginedMemberRoleId)
                    ->where('menu_id', $menuId)
                    ->first()->menu_function_id;

                $memberMenuFunctionModuleArray = json_decode($getMembermenuFunctionModule, true);



                // Initialize the menu item with its name and an empty functions array
                $menuData = [
                    'menuName' => $MenuName,
                    'menuFunctions' => []
                ];


                for ($k = 0; $k < count($memberMenuFunctionModuleArray); $k++) {
                    $mfId = $memberMenuFunctionModuleArray[$k];

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
