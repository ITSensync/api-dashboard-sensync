<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparingController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\DataCountController;


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

    // Route::get('sparing/{id_device}', [SparingController::class, 'show']);
    // Route::get('sparing/status/{id_device}', [SparingController::class, 'status']);
    Route::get('sparing/data', [GetDataController::class, 'getData']);
    Route::get('sparing/mutu', [GetDataController::class, 'getDataMutu']);
    Route::get('sparing/data-count', [GetDataController::class, 'getCountData']);
    Route::get('sparing/sparing-weekly-data/{id}', [GetDataController::class, 'getWeeklyDataById']);
    Route::get('sparing/percentages', [GetDataController::class, 'getMonthlyAveragePercentages']);
    Route::get('sparing/percentages/all', [GetDataController::class, 'getMonthlyAveragePercentageForAllSites']);
    Route::get('sparing/percentages/bandung', [GetDataController::class, 'getMonthlyAveragePercentageForBandungSites']);
    Route::get('sparing/percentages/nonbandung', [GetDataController::class, 'getMonthlyAveragePercentageForNonBandungSites']);
    Route::get('sparing/percentages/pwk', [GetDataController::class, 'getMonthlyAveragePercentageForIndoramaPWKSites']);



    Route::get('sparing/sparing-hours-data/{id}', [GetDataController::class, 'getWeeklyDataHoursById']);


