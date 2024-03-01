<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class BaseSparing extends Model
{
    protected $fillable = [
        'time',
        'cod',
        'tss',
        'ph',
        'nh3n',
        'debit2',
        'debit',
        'bakumutu',
        // tambahkan kolom lain jika diperlukan
    ];

    public static function getDataForDashboard($table, $title, $latitude, $longitude)
    {
        $cacheKey = "dashboard_data_$table";
        $minutes = 10; // Cache for 10 minutes (adjust as needed)

        return Cache::remember($cacheKey, $minutes, function () use ($table, $title, $latitude, $longitude) {
            date_default_timezone_set('Asia/Jakarta');
            $currentTime = date('H:i:s');
            $minh = date('Y-m-d 00:00:01');
            $tgll = date('Y-m-d 23:59:59');

            $query = "SELECT COUNT(*) AS total FROM `$table` WHERE `time` BETWEEN '$minh' AND '$tgll'";
            $totalData = DB::select($query);

            // Hitung berapa banyak interval waktu yang telah berlalu sejak jam 00:00:01
            list($hour, $minute, $second) = explode(':', $currentTime);
            $intervalCount = ($hour * 60 * 60 + $minute * 60 + $second) / 120; // Interval 2 menit

            $data_should_be = round($intervalCount);

            $query2 = "SELECT `time` FROM `$table` ORDER BY `time` DESC LIMIT 1";
            $data = DB::select($query2);

            if (!empty($data)) {
                $count = $totalData[0]->total;
                $percent = ($count / $data_should_be) * 100;
                $percentFormatted = number_format($percent, 2);
                $percentFloat = floatval($percentFormatted); // Konversi ke float
                $diff = $data_should_be - $count;

                $result = [
                    'uuid' => Str::uuid(),
                    'id' => $table,
                    'time' => $data[0]->time,
                    'title' => $title,
                    'data_should_be' => $data_should_be,
                    'data_count' => $count,
                    'percent' => $percentFloat,
                    'diff' => $diff,
                    'Latitude' => $latitude,
                    'Longitude' => $longitude,
                ];

                return $result;
            }

            return null;
        });
    }

    public static function getDevices()
    {
        $cacheKey = 'devices_data';
        $minutes = 60; // Cache for 1 hour (adjust as needed)
        return Cache::remember($cacheKey, $minutes, function () {
        return [
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
                'longitude' => 107.4187869,
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
        ];
    });
}
}
