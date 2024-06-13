<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparingController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\GetDataHoursController;
use App\Http\Controllers\ApiRoutesController;
use App\Http\Controllers\PreviousMonthDataController;


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



    Route::get('sparing/data', [GetDataController::class, 'getData']);
    Route::get('sparing/mutu', [GetDataController::class, 'getDataMutu']);
    Route::get('sparing/data-count', [GetDataController::class, 'getCountData']);

    // router sparing per2mnt
    Route::get('sparing/sparing-weekly-data/{id}', [GetDataController::class, 'getWeeklyDataById']);
    Route::get('sparing/percentages', [GetDataController::class, 'getMonthlyAveragePercentages']);
    Route::get('sparing/percentages/all', [GetDataController::class, 'getMonthlyAveragePercentageForAllSites']);
    Route::get('sparing/percentages/bandung', [GetDataController::class, 'getMonthlyAveragePercentageForBandungSites']);
    Route::get('sparing/percentages/nonbandung', [GetDataController::class, 'getMonthlyAveragePercentageForNonBandungSites']);
    Route::get('sparing/percentages/pwk', [GetDataController::class, 'getMonthlyAveragePercentageForIndoramaPWKSites']);


// router sparing perjam
    Route::get('sparing/sparing-hours-data/{id}', [GetDataHoursController::class, 'getWeeklyDataHoursById']);
    Route::get('sparing/percentages-hours/all', [GetDataHoursController::class, 'getMonthlyAveragePercentageHoursForAllSites']);
    Route::get('sparing/percentages-hours/bandung', [GetDataHoursController::class, 'getMonthlyAveragePercentageHoursForBandungSites']);
    Route::get('sparing/percentages-hours/nonbandung', [GetDataHoursController::class, 'getMonthlyAveragePercentageHoursForNonBandungSites']);
    Route::get('sparing/percentages-hours/pwk', [GetDataHoursController::class, 'getMonthlyAveragePercentageHoursForIndoramaPWKSites']);


// router histroy data per 2 menit
    Route::get('sparing/previous-month-data/{id}/{month}/{year}', [PreviousMonthDataController::class, 'getPreviousMonthData']);
    Route::get('sparing/percentages/{month}/{year}', [PreviousMonthDataController::class, 'getPreviousAveragePercentages']);
    Route::get('sparing/percentages/all/{month}/{year}', [PreviousMonthDataController::class, 'getPreviousAveragePercentagesAllSites']);
    Route::get('sparing/percentages/bandung/{month}/{year}', [PreviousMonthDataController::class, 'getPreviousAveragePercentagesBandungSites']);
    Route::get('sparing/percentages/nonbandung/{month}/{year}', [PreviousMonthDataController::class, 'getPreviousAveragePercentagesNonBandungSites']);