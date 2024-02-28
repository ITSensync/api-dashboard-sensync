<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetDataController extends Controller
{
    public function getData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $minh = date('Y-m-d 00:00:01');
        $tgll = date('Y-m-d 23:59:59');

        $main = [];

        $devicelocations = [
            'sparing01' => ['Gistex', -6.9374571, 107.5364919],
            'sparing02' => ['Indorama PWK', -6.5531083, 107.4101544],
            'sparing03' => ['PMT', -6.9226832, 107.5413683],
            'sparing04' => ['Indorama PDL', -6.8953855, 107.4959834],
            'sparing05' => ['Besland', -6.4493131, 107.4572677],
            'sparing06' => ['Indotaisei', -6.4244492, 107.4187869],
            'sparing07' => ['Daliatex', -6.9801221, 107.6185288],
            'cpp' => ['CPP', -6.5531083, 107.4101544],
            'ipci' => ['IPCI', -6.5531083, 107.4101544],
            'spinning' => ['SPINNING', -6.5531083, 107.4101544],
            'weaving01' => ['WEAVING01', -6.5531083, 107.4101544],
            'weaving02' => ['WEAVING02', -6.5531083, 107.4101544],
            'sparing08' => ['Papyrus', -6.5531083, 107.4101544],
            'sparing09' => ['BCP', -6.5531083, 107.4101544],
            'sparing10' => ['Pangjaya', -6.5671703, 106.5889997],
            'sparing_demo_tb' => ['Sparing Demo', -6.5671703, 106.5889997],
        ];

        foreach ($devicelocations as $idss => $device) {
            // Pengecekan apakah $idss ada dalam daftar devicelocations
            if (!array_key_exists($idss, $devicelocations)) {
                return response()->json(['status' => 'ERR', 'message' => 'Device ID tidak betul'], 400);
            }

            // Ambil data per hari dari tabel
            $query = "SELECT COUNT(*) AS total FROM `$idss` WHERE `time` BETWEEN '$minh' AND '$tgll'";
            $totalData = DB::select($query);


            // Ambil data terakhir dari tabel
            $query2 = "SELECT * FROM `$idss` ORDER BY `time` DESC LIMIT 1";
            $data = DB::select($query2);

            if (!empty($data)) {
                $count = $totalData[0]->total;
                $percent = number_format(($count / 720) * 100, 2) . '%';
                $diff = 720 - $count;



                $submain = [
                    'uuid' => Str::uuid(), // Generate UUID
                    'id' => $idss,
                    'time' => $data[0]->time,
                    'title' => $device[0],
                    'data_count' => $count,
                    'percent' => $percent, // Tambahkan data percent
                    'diff' => $diff, // Tambahkan data diff
                    'Latitude' => $device[1],
                    'Longitude' => $device[2],
                ];

                // if ($idss == "sparing06") {
                //     $baku = ($data[0]->cod > 100 || $data[0]->tss > 150 || $data[0]->nh3n > 20) ? "nilai melebihi baku mutu" : "aman";
                // } elseif ($idss == "sparing02") {
                //     $baku = ($data[0]->cod > 125 || $data[0]->tss > 40 || $data[0]->nh3n > 20) ? "nilai melebihi baku mutu" : "aman";
                // } else {
                //     $baku = "aman";
                // }

                // $submain['Baku Mutu'] = $baku;
                $main[] = $submain;
            }
        }

        return response()->json(['status' => 'OK', 'message' => 'success', 'data' => $main]);
    }
}
