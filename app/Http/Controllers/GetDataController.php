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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetDataController extends Controller
{

    public function getData()
    {
        $devices = [
            'Sparing01' => [
                'table' => 'sparing01',
                'title' => 'Gistex',
                'latitude' => -6.9374571,
                'longitude' => 107.5364919,
            ],
            'Sparing02' => [
                'table' => 'sparing02',
                'title' => 'Indorama PWK',
                'latitude' => -6.5531083,
                'longitude' => 107.4101544,
            ],
            'Sparing03' => [
                'table' => 'sparing03',
                'title' => 'PMT',
                'latitude' => -6.9226832,
                'longitude' => 107.5413683,
            ],
            'Sparing04' => [
                'table' => 'sparing04',
                'title' => 'Indorama PDL',
                'latitude' => -6.8953855,
                'longitude' => 107.4959834,
            ],
            'Sparing05' => [
                'table' => 'sparing05',
                'title' => 'Besland',
                'latitude' => -6.4493131,
                'longitude' => 107.4572677,
            ],
            'Sparing06' => [
                'table' => 'sparing06',
                'title' => 'Indotaisei',
                'latitude' => -6.4244492,
                'longitude' =>107.4187869,
            ],
            'Sparing07' => [
                'table' => 'sparing07',
                'title' => 'Daliatex',
                'latitude' => -6.9801221,
                'longitude' => 107.6185288,
            ],
            'Sparing08' => [
                'table' => 'sparing08',
                'title' => 'Papyrus',
                'latitude' => -7.0384787,
                'longitude' => 107.5906626,
            ],
            'Sparing09' => [
                'table' => 'sparing09',
                'title' => 'BCP',
                'latitude' => -7.0465691,
                'longitude' => 107.7506977,
            ],
            'Sparing10' => [
                'table' => 'sparing10',
                'title' => 'Pangjaya',
                'latitude' => -6.5671703,
                'longitude' => 106.5889997,
            ],
            
            // Tambahkan informasi untuk Sparing02, Sparing03, dan seterusnya
        ];

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
                    'nama' => $parameter,
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
