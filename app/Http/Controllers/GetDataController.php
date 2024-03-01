<?php

namespace App\Http\Controllers;

use App\Models\Sparing01;
use App\Models\Sparing02;
use App\Models\Sparing03;
use App\Models\Sparing04;
use App\Models\Sparing05;
use App\Models\Sparing06;
use App\Models\Sparing07;
use App\Models\Sparing08;
use App\Models\Sparing09;
use App\Models\Sparing10;
use App\Models\Sparing11;
use App\Models\BaseSparing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetDataController extends Controller
{

    public function getData()
    {
        $devices = BaseSparing::getDevices();


        $main = []; 
        foreach ($devices as $modelName => $deviceInfo) {
            $model = "App\\Models\\$modelName";
            $data = $model::getDataForDashboard($deviceInfo['table'], $deviceInfo['title'], $deviceInfo['latitude'], $deviceInfo['longitude']);
            if ($data) {
                $main[] = $data;
            }
        }

        return response()->json(['status' => 'OK', 'message' => 'success', 'data' => $main]);
    }


    public function getDataMutu()
    {
        $devices = [
            'Sparing01',
            'Sparing02',
            'Sparing03',
            'Sparing04',
            'Sparing05',
            'Sparing06',
            'Sparing07',
            'Sparing08',
            'Sparing09',
            'Sparing10',
        ];

        $data = [];
        foreach ($devices as $device) {
            $model = "App\Models\\$device";
            $deviceData = $model::getData();
            $lastData = $model::orderBy('time', 'desc')->first();

            $deviceValue = [];
            foreach ($deviceData['bakumutu'] as $parameter => $value) {
                $deviceValue[] = [
                    'name' => $parameter,
                    'value' => $lastData->$parameter,
                    'unit' => 'mg/L', // Unit disesuaikan dengan kebutuhan
                    'min' => $value['min'],
                    'max' => $value['max']
                ];
            }

            // Tentukan status
            $status = 'Baik';
            foreach ($deviceValue as $value) {
                if ($value['value'] > $value['max']) {
                    $status = 'Melebihi baku mutu';
                    break;
                }
            }

            $data[] = [
                'uuid' => uniqid(),
                'id' => $deviceData['id'],
                'time' => $lastData->time,
                'title' => $deviceData['nama'],
                'status' => $status, // Status bisa disesuaikan dengan kondisi nyata
                'value' => $deviceValue
            ];
        }
        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => $data
        ]);
    }
}
