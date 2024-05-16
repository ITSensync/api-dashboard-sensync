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


    public function getCountData()
    {
        $totalExpectedData = 5040;
        $data = [
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing01',
                'title' => 'gistex',
                'data_count' => Sparing01::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing01::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing02',
                'title' => 'indorama PWK',
                'data_count' => Sparing02::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing02::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],

            [
                'uuid' => Str::uuid(),
                'id' => 'sparing03',
                'title' => 'PMT',
                'data_count' => Sparing03::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing03::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing04',
                'title' => 'indorama PDL',
                'data_count' => Sparing04::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing04::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing05',
                'title' => 'Besland',
                'data_count' => Sparing05::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing05::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing06',
                'title' => 'Indotaisei',
                'data_count' => Sparing06::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing06::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing07',
                'title' => 'Daliatex',
                'data_count' => Sparing07::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing07::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing08',
                'title' => 'Papyrus',
                'data_count' => Sparing08::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing08::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing09',
                'title' => 'BCP',
                'data_count' => Sparing09::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing09::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing10',
                'title' => 'Pangjaya',
                'data_count' => Sparing10::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing10::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
            [
                'uuid' => Str::uuid(),
                'id' => 'sparing11',
                'title' => 'LPA',
                'data_count' => Sparing11::where('time', '>=', now()->subWeek())->count(),
                'interval_date' => now()->subWeek()->format('d/m/Y') . ' - ' . now()->subDays(1)->format('d/m/Y'),
                'percent' => min(round(Sparing11::where('time', '>=', now()->subWeek())->count() / $totalExpectedData * 100, 2), 100)
            ],
        ];
        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => $data
        ]);
    }
    private function calculatePercentage($count, $totalExpected)
    {
        return $totalExpected != 0 ? ($count / $totalExpected) * 100 : 0;
    }


    public function getWeeklyDataById($id)
    {
        $validIds = [
            'sparing01' => 'Gistex',
            'sparing02' => 'Indorama PWK',
            'sparing03' => 'PMT',
            'sparing04' => 'Indorama PDL',
            'sparing05' => 'Besland',
            'sparing06' => 'Indotaisei',
            'sparing07' => 'Daliatex',
            'sparing08' => 'Papyrus',
            'sparing09' => 'BCP',
            'sparing10' => 'Pangjaya',
            'sparing11' => 'LPA',
            'weaving01' => 'weaving01',
            'weaving02' => 'weaving02',
            'spinning' => 'spinning',
        ];
    
        if (!array_key_exists($id, $validIds)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid ID Provider'
            ], 400);
        }
    
        $title = $validIds[$id];
    
        $query = "
        SELECT 
            year_week,
            MIN(time) AS start_date,
            MAX(time) AS end_date,
            COUNT(*) AS total_records
        FROM (
            SELECT 
                YEARWEEK(time, 1) AS year_week,
                time
            FROM $id
            WHERE 
                (YEAR(time) = 2024 AND MONTH(time) = 5) OR
                (YEAR(time) > 2024 AND MONTH(time) >= 5) 
                AND WEEKDAY(time) BETWEEN 0 AND 6 AND
                time >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
        ) AS subquery
        GROUP BY year_week
        ORDER BY year_week;
        ";
    
        $results = DB::select(DB::raw($query));
    
        // Format output JSON
        $data = [];
        foreach ($results as $result) {
            $interval_date = date('d/m/Y', strtotime($result->start_date)) . ' - ' . date('d/m/Y', strtotime($result->end_date));
            $data_count = $result->total_records;
    
            // Hitung persentase
            $expected_count = 5040;
            $percent = ($data_count / $expected_count) * 100;
            if ($percent > 100) {
                $percent = 100;
            }
            $percent = number_format($percent, 2);
    
            $data[] = [
                'interval_date' => $interval_date,
                'data_count' => $data_count,
                'percent' => $percent
            ];
        }
    
        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'id' => $id,
            'title' => $title,
            'data' => $data
        ]);
    }
    
    
}
