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
    // public function getData()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $currentTime = date('H:i:s');
    //     $minh = date('Y-m-d 00:00:01');
    //     $tgll = date('Y-m-d 23:59:59');

    //     $main = [];

    //     $devicelocations = [
    //         'sparing01' => ['PT Gistex Textile Division', -6.9374571, 107.5364919],
    //         'sparing02' => ['PT.INDO-RAMA SYNTHETICS.Tbk', -6.5531083, 107.4101544],
    //         'sparing03' => ['PT Pulau Mas Texindo', -6.9226832, 107.5413683],
    //         'sparing04' => ['PT.INDO-RAMA SYNTHETICS.Tbk, KAB. Bandung Barat', -6.8953855, 107.4959834],
    //         'sparing05' => ['Kawasan Berikat Pt Besland Indo', -6.4493131, 107.4572677],
    //         'sparing06' => ['PT. Indotaisei Indah Development', -6.4244492, 107.4187869],
    //         'sparing07' => ['PT Daliatex Kusuma', -6.9801221, 107.6185288],
    //         'sparing08' => ['PT. Papyrus Sakti Paper Mill"', -6.5531083, 107.4101544],
    //         'sparing09' => ['PT. BINTANG CIPTAPERKASA', -6.5531083, 107.4101544],
    //         'sparing10' => ['PT. Sinar Pangjaya Mulia', -6.5671703, 106.5889997],
    //     ];

    //     foreach ($devicelocations as $idss => $device) {
    //         // Pengecekan apakah $idss ada dalam daftar devicelocations
    //         if (!array_key_exists($idss, $devicelocations)) {
    //             return response()->json(['status' => 'ERR', 'message' => 'Device ID tidak betul'], 400);
    //         }

    //         // Ambil total data dari tabel
    //         $query = "SELECT COUNT(*) AS total FROM `$idss` WHERE `time` BETWEEN '$minh' AND '$tgll'";
    //         $totalData = DB::select($query);

    //         // Hitung berapa banyak interval waktu yang telah berlalu sejak jam 00:00:01
    //         list($hour, $minute, $second) = explode(':', $currentTime);
    //         $intervalCount = ($hour * 60 * 60 + $minute * 60 + $second) / 120; // Interval 2 menit

    //         $data_should_be = round($intervalCount);

    //         // Ambil data terakhir dari tabel
    //         $query2 = "SELECT `time` FROM `$idss` ORDER BY `time` DESC LIMIT 1";
    //         $data = DB::select($query2);

    //         if (!empty($data)) {
    //             $count = $totalData[0]->total;
    //             $percent = number_format(($count / $data_should_be) * 100, 2) . '%';
    //             $diff = $data_should_be - $count;

    //             $submain = [
    //                 'uuid' => Str::uuid(), // Generate UUID
    //                 'id' => $idss,
    //                 'time' => $data[0]->time,
    //                 'title' => $device[0],
    //                 'data_should_be' => $data_should_be, // Jumlah data yang seharusnya pada jam tertentu
    //                 'data_count' => $count,
    //                 'percent' => $percent, // Tambahkan data percent
    //                 'diff' => $diff, // Tambahkan data diff
    //                 'Latitude' => $device[1],
    //                 'Longitude' => $device[2],
    //             ];

    //             $main[] = $submain;
    //         }
    //     }

    //     return response()->json(['status' => 'OK', 'message' => 'success', 'data' => $main]);
    // }

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
