<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GetDataHoursController extends Controller
{

    // rata rata data sparing perjam mingguan
    public function getWeeklyDataHoursById($id)
    {
        $validIds = [
            'sparing01_lap' => 'Gistex',
            'sparing02_lap' => 'Indorama PWK',
            'sparing03_lap' => 'PMT',
            'sparing04_lap' => 'Indorama PDL',
            'sparing05_lap' => 'Besland',
            'sparing06_lap' => 'Indotaisei',
            'sparing07_lap' => 'Daliatex',
            'sparing08_lap' => 'Papyrus',
            'sparing09_lap' => 'BCP',
            'sparing10_lap' => 'Pangjaya',
            'sparing11_lap' => 'LPA',
            'weaving01_lap' => 'weaving01',
            'weaving02_lap' => 'weaving02',
            'spinning_lap' => 'spinning',
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
        WEEK(time, 1) AS week,
        YEAR(time) AS year,
        MIN(time) AS start_date,
        MAX(time) AS end_date,
        COUNT(*) AS total_records
    FROM $id
    WHERE MONTH(time) = MONTH(CURDATE()) AND YEAR(time) = YEAR(CURDATE())
    GROUP BY week, year
    ORDER BY week;
";




        $results = DB::select(DB::raw($query));

        // Format output JSON
        $data = [];
        $week_in_month = [];

        foreach ($results as $result) {
            $start_date = strtotime($result->start_date);
            $end_date = strtotime($result->end_date);

            $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

            // Hitung persentase beradasrkan jumlah hari 
            $expected_count = 720 * $days;
            $data_count = $result->total_records;
            $percent = ($data_count / $expected_count) * 100;
            if ($percent > 100) {
                $percent = 100;
            }
            $percent = number_format($percent, 2);

            // Menentukan minggu keberapa dalam bulan ini
            $start_week = date('W', $start_date);
            $start_month = date('n', $start_date);
            $start_year = date('Y', $start_date);

            if (!isset($weeks_in_month[$start_year])) {
                $weeks_in_month[$start_year] = [];
            }
            if (!isset($weeks_in_month[$start_year][$start_month])) {
                $weeks_in_month[$start_year][$start_month] = 0;
            }
            $weeks_in_month[$start_year][$start_month]++;
            $week_in_month = $weeks_in_month[$start_year][$start_month];

            // Format interval_date
            $interval_date = date('d M', $start_date) . ' - ' . date('d M', $end_date);

            $data[] = [
                'week' => $week_in_month,
                'year' => date('Y', $start_date),
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
