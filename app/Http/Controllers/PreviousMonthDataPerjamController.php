<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreviousMonthDataPerjamController extends Controller
{
    // rata rata sparing mingguan 
    public function getPreviousMonthDataPerjam($id, $month, $year)
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
        $title = $validIds[$id];

        // Query untuk mendapatkan data bulan sebelumnya
        $query = "
            SELECT 
                WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
                YEAR(CONCAT(tanggal, ' ', jam)) AS year,
                MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
                MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
                COUNT(*) AS total_records
            FROM $id
            WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
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
            $expected_count = 24 * $days;
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
                'month' => $month,
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


    // rata rata sparing bulanan
    public function getPreviousAveragePercentagesPerjam($month, $year)
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
            'weaving01_lap' => 'Weaving01',
            'weaving02_lap' => 'Weaving02',
            'spinning_lap' => 'Spinning',
        ];

        $monthlyAverages = [];

        foreach ($validIds as $id => $title) {
            $query = "
        SELECT
            WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
            YEAR(CONCAT(tanggal, ' ', jam)) AS year,
            MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
            MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
            COUNT(*) AS total_records
        FROM $id
        WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
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
                    'year' => $year,
                    'month' => $month,
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
    public function getPreviousAveragePercentagesAllSitesPerjam($month, $year)
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
            'weaving01_lap' => 'Weaving01',
            'weaving02_lap' => 'Weaving02',
            'spinning_lap' => 'Spinning',
        ];

        $allWeeklyPercentages = [];

        foreach ($validIds as $id => $title) {
            $query = "
            SELECT 
                WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
                YEAR(CONCAT(tanggal, ' ', jam)) AS year,
                MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
                MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
                COUNT(*) AS total_records
            FROM $id
            WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
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
                'year' => $year,
                'month' => $month,
                'average_percent' => $averagePercent,
            ];
        } else {
            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'all site',
                'year' => $result->year,
                'month' => $result->month,
                'average_percent' => '0.00',
            ];
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => [$monthlyAverage]
        ]);
    }


    // rata rata site sparing bandung 
    public function getPreviousAveragePercentagesBandungSitesPerjam($month, $year)
    {
        $bandungIds = [
            'sparing01_lap' => 'Gistex',
            'sparing03_lap' => 'PMT',
            'sparing04_lap' => 'Indorama PDL',
            'sparing07_lap' => 'Daliatex',
            'sparing08_lap' => 'Papyrus',
            'sparing09_lap' => 'BCP',
            'sparing10_lap' => 'Pangjaya',
        ];

        $BandungPercentages = [];

        foreach ($bandungIds as $id => $title) {
            $query = "
            SELECT 
                WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
                YEAR(CONCAT(tanggal, ' ', jam)) AS year,
                MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
                MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
                COUNT(*) AS total_records
            FROM $id
            WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
            GROUP BY week, year
            ORDER BY week;
            ";

            $results = DB::select(DB::raw($query), [$month, $year]);

            foreach ($results as $result) {
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);
                $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

                $expected_count = 720 * $days;
                $data_count = $result->total_records;
                $percent = ($data_count / $expected_count) * 100;

                if ($percent > 100) {
                    $percent = 100;
                }
                $percent = number_format($percent, 2);

                $BandungPercentages[] = $percent;
            }
        }

        // Calculate the overall monthly average percentage for Bandung sites
        if (count($BandungPercentages) > 0) {
            $averagePercent = array_sum($BandungPercentages) / count($BandungPercentages);
            $averagePercent = number_format($averagePercent, 2);

            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
                'average_percent' => $averagePercent,
            ];
        } else {
            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
                'average_percent' => '0.00',
            ];
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => [$monthlyAverage]
        ]);
    }


    // rata rata site sparing non bandung
    public function getPreviousAveragePercentagesNonBandungSitesPerjam($month, $year)
    {
        $nonBandungIds = [
            'sparing02_lap' => 'Indorama PWK',
            'sparing05_lap' => 'Besland',
            'sparing06_lap' => 'Indotaisei',
            'sparing11_lap' => 'LPA',

        ];

        $nonBandungPercentages = [];

        foreach ($nonBandungIds as $id => $title) {
            $query = "
              SELECT 
                WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
                YEAR(CONCAT(tanggal, ' ', jam)) AS year,
                MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
                MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
                COUNT(*) AS total_records
              FROM $id
              WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
              GROUP BY week, year
              ORDER BY week;
              ";

            $results = DB::select(DB::raw($query), [$month, $year]);

            foreach ($results as $result) {
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);
                $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

                $expected_count = 720 * $days;
                $data_count = $result->total_records;
                $percent = ($data_count / $expected_count) * 100;

                if ($percent > 100) {
                    $percent = 100;
                }
                $percent = number_format($percent, 2);

                $nonBandungPercentages[] = $percent;
            }
        }

        // Calculate the overall monthly average percentage for Bandung sites
        if (count($nonBandungPercentages) > 0) {
            $averagePercent = array_sum($nonBandungPercentages) / count($nonBandungPercentages);
            $averagePercent = number_format($averagePercent, 2);

            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
                'average_percent' => $averagePercent,
            ];
        } else {
            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
                'average_percent' => '0.00',
            ];
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Success',
            'data' => [$monthlyAverage]
        ]);
    }

    // rata rata site sparing pwk
    public function getPreviousAveragePercentagesPWKSitesPerjam($month, $year)
    {
        $pwkIds = [
            'weaving01_lap' => 'Weaving 01',
            'weaving02_lap' => 'Weaving 02',
            'spinning_lap' => 'Spinning',
        ];

        $pwkPercentages = [];

        foreach ($pwkIds as $id => $title) {
            $query = "
               SELECT 
                WEEK(CONCAT(tanggal, ' ', jam), 1) AS week,
                YEAR(CONCAT(tanggal, ' ', jam)) AS year,
                MIN(CONCAT(tanggal, ' ', jam)) AS start_date,
                MAX(CONCAT(tanggal, ' ', jam)) AS end_date,
                COUNT(*) AS total_records
               FROM $id
               WHERE MONTH(tanggal) = ? AND YEAR(tanggal) = ?
               GROUP BY week, year
               ORDER BY week;
               ";

            $results = DB::select(DB::raw($query), [$month, $year]);

            foreach ($results as $result) {
                $start_date = strtotime($result->start_date);
                $end_date = strtotime($result->end_date);
                $days = (int)ceil(($end_date - $start_date + 1) / (60 * 60 * 24));

                $expected_count = 720 * $days;
                $data_count = $result->total_records;
                $percent = ($data_count / $expected_count) * 100;

                if ($percent > 100) {
                    $percent = 100;
                }
                $percent = number_format($percent, 2);

                $pwkPercentages[] = $percent;
            }
        }

        // Calculate the overall monthly average percentage for Bandung sites
        if (count($pwkPercentages) > 0) {
            $averagePercent = array_sum($pwkPercentages) / count($pwkPercentages);
            $averagePercent = number_format($averagePercent, 2);

            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
                'average_percent' => $averagePercent,
            ];
        } else {
            $monthlyAverage = [
                'id' => 'sparing',
                'title' => 'Bandung sites',
                'year' => $year,
                'month' => $month,
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
