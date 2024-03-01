<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            $percent = number_format(($count / $data_should_be) * 100, 2) . '%';
            $diff = $data_should_be - $count;

            $result = [
                'uuid' => Str::uuid(),
                'id' => $table,
                'time' => $data[0]->time,
                'title' => $title,
                'data_should_be' => $data_should_be,
                'data_count' => $count,
                'percent' => $percent,
                'diff' => $diff,
                'Latitude' => $latitude,
                'Longitude' => $longitude,
            ];

            return $result;
        }

        return null;
    }
}
