<?php

use App\Http\Controllers\Api\Version_1\Controller\Organization\OrganizationController;
use App\Http\Controllers\Api\Version_1\Controller\Organization\OrganizationDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
include_once('version_1/organization.php');
