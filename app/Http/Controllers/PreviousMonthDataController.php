<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreviousMonthDataController extends Controller
{
    // rata rata sparing mingguan 
    public function getPreviousMonthData($id, $month, $year)
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
        $title = $validIds[$id];

        // Query untuk mendapatkan data bulan sebelumnya
        $query = "
            SELECT 
                WEEK(time, 1) AS week,
                YEAR(time) AS year,
                MIN(time) AS start_date,
                MAX(time) AS end_date,
                COUNT(*) AS total_records
            FROM $id
            WHERE MONTH(time) = ? AND YEAR(time) = ?
            GROUP BY week, year
            ORDER BY week;
        ";

        // Eksekusi query dengan parameter bulan dan tahun
        $results = DB::select(DB::raw($query), [$month, $year]);

        // Format output JSON
        $data = [];
        foreach ($results as $result) {
            $start_date = strtotime($result->start_date);
            $end_date = strtotime($result->end_date);

            $days = (int) ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

            // Hitung persentase berdasarkan jumlah hari 
            $expected_count = 720 * $days;
            $data_count = $result->total_records;
            $percent = ($data_count / $expected_count) * 100;
            if ($percent > 100) {
                $percent = 100;
            }
            $percent = number_format($percent, 2);

            // Format interval_date
            $interval_date = date('d M', $start_date) . ' - ' . date('d M', $end_date);

            $data[] = [
                // 'week' => $result->week,
                'year' => $result->year,
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


    public function getPreviousAveragePercentages($month, $year)
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
            'weaving01' => 'Weaving01',
            'weaving02' => 'Weaving02',
            'spinning' => 'Spinning',
        ];

        $monthlyAverages = [];

        foreach ($validIds as $id => $title) {
            $query = "
            SELECT
                WEEK(time, 1) AS week,
                YEAR(time) AS year,
                MIN(time) AS start_date,
                MAX(time) AS end_date,
                COUNT(*) AS total_records
            FROM $id
            WHERE MONTH(time) = ? AND YEAR(time) = ?
            GROUP BY week, year
            ORDER BY week;
        ";

            $results = DB::select(DB::raw($query), [$month, $year]);

            $weeklyPercentages = [];
            foreach ($results as $result) {
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);
                $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

                // Calculate expected count based on the number of days
                $expected_count = 720 * $days;
                $data_count = $result->total_records;
                $percent = ($data_count / $expected_count) * 100;
                if ($percent > 100) {
                    $percent = 100;
                }
                $percent = number_format($percent, 2);

                $weeklyPercentages[] = $percent;
            }

            // Calculate the monthly average percentage
            if (count($weeklyPercentages) > 0) {
                $averagePercent = array_sum($weeklyPercentages) / count($weeklyPercentages);
                $averagePercent = number_format($averagePercent, 2);

                $monthlyAverages[] = [
                    'id' => $id,
                    'title' => $title,
                    'average_percent' => $averagePercent,
                ];
            }
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => $monthlyAverages
        ]);
    }


    // rata rata semua site sparing 
    public function getPreviousAveragePercentagesAllSites($month, $year)
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
            'weaving01' => 'Weaving01',
            'weaving02' => 'Weaving02',
            'spinning' => 'Spinning',
        ];

        $allWeeklyPercentages = [];

        foreach ($validIds as $id => $title) {
            $query = "
            SELECT 
                WEEK(time, 1) AS week,
                YEAR(time) AS year,
                MIN(time) AS start_date,
                MAX(time) AS end_date,
                COUNT(time) AS total_records
            FROM $id
            WHERE MONTH(time) = ? AND YEAR(time) = ?
            GROUP BY week, year
            ORDER BY week;
            ";

            $results = DB::select(DB::raw($query), [$month, $year]);

            // Calculate the weekly percentages
            foreach ($results as $result) {
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);
                $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

                // Calculate expected count based on the number of days
                $expected_count = 720 * $days;
                $data_count = $result->total_records;
                $percent = ($data_count / $expected_count) * 100;
                if ($percent > 100) {
                    $percent = 100;
                }
                $percent = number_format($percent, 2);

                $allWeeklyPercentages[] = $percent;
            }
        }

        // Calculate the overall monthly average percentage
        if (count($allWeeklyPercentages) > 0) {
            $averagePercent = array_sum($allWeeklyPercentages) / count($allWeeklyPercentages);
            $averagePercent = number_format($averagePercent, 2);

            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'all site',
                'average_percent' => $averagePercent,
            ];
        } else {
            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'all site',
                'average_percent' => '0.00',
            ];
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => [$monthlyAverage]
        ]);
    }
}
