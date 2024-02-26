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
use Monolog\Handler\BrowserConsoleHandler;
use PhpParser\Node\Stmt\Break_;

class SparingController extends Controller
{
    public function show(Request $request, $id_device)
    {
        $tb = '';
        $site = '';

        switch ($id_device) {
            case 'sparing01':
                $tb = "sparing01";
                $site = "Gistex";
                break;
            case 'sparing02':
                $tb = "sparing02";
                $site = "Indorama PWK";
                break;
            case 'sparing03':
                $tb = "sparing03";
                $site = "PMT";
                break;

            case 'sparing04':
                $tb = "sparing04";
                $site = "Indorama PDL";
                break;

            case 'sparing05':
                $tb = "sparing05";
                $site = "Besland";
                break;

            case 'sparing06':
                $tb = "sparing06";
                $site = "Indotaisei";
                break;

            case 'sparing07':
                $tb = "sparing07";
                $site = "daliatex";
                break;

            case 'sparing08':
                $tb = "sparing08";
                $site = "papyrus";
                break;

            case 'sparing09':
                $tb = "sparing09";
                $site = "BCP";
                break;

            case 'sparing10':
                $tb = "sparing10";
                $site = "Pangjaya";
                break;

            default:
                // default action
        }

        if (!empty($tb)) {
            $hari = $request->input('tanggal', now()->format('Y-m-d'));
            $hari2 = $request->input('tanggal-akhir', now()->format('Y-m-d H:i:s'));

            $query = DB::table($tb)
                ->where('time', '>=', $hari . ' 00:00:00')
                ->where('time', '<=', $hari2 . ' 23:59:59')
                ->orderBy('time', 'desc')
                ->get();

            if ($query->count() > 0) {
                $data = $query->toArray();
            } else {
                $data = "Data tidak ada";
            }
            $data = [];
            foreach ($query as $row) {
                $data['WAKTU'][] = $row->time;
                $data['PH'][] = $row->ph;
                $data['COD'][] = $row->cod;
                $data['NH3N'][] = $row->nh3n;
                $data['TSS'][] = $row->tss;
                $data['DEBIT'][] = $row->debit2;
            }

            $response = [
                'id_device' => $id_device,
                'site' => $site,
                'tanggal' => $hari,
                'tanggal-akhir' => $hari2,
                'data' => $data,
            ];

            return response()->json($response);
        } else {
            return response()->json(['error' => 'Device ID tidak valid'], 400);
        }
    }


    public function status(Request $request, $id_device)
    {
        switch ($id_device) {
            case 'sparing01':
                $model = Sparing01::class;
                break;
            case 'sparing02':
                $model = Sparing02::class;
                break;
            case 'sparing03':
                $model = Sparing03::class;
                break;
            case 'sparing04':
                $model = Sparing04::class;
                break;
            case 'sparing05':
                $model = Sparing05::class;
                break;
            case 'sparing06':
                $model = Sparing06::class;
                break;

            case 'sparing07':
                $model = Sparing07::class;
                break;
            case 'sparing08':
                $model = Sparing08::class;
                break;
            case 'sparing03':
                $model = Sparing09::class;
                break;
            case 'sparing03':
                $model = Sparing10::class;
                break;
            case 'sparing03':
                $model = Sparing11::class;
                break;
            default:
                return response()->json(['error' => 'Device ID tidak valid'], 400);
        }

        $deviceInfo = $model::getData();
        $data = $model::orderBY('time', 'desc')->first();

        $status = ($data && strtotime($data->time) > strtotime('-5 minutes')) ? 'online' : 'offline';

        return response()->json([
            'id_device' => $deviceInfo,
            'last_update' => $data ? $data->time : null,
            'status' => $status,
            'data' => $data ? [
                'cod' => $data->cod,
                'tss' => $data->tss,
                'ph' => $data->ph,
                'nh3n' => $data->nh3n,
                'debit' => $data->debit2,
            ] : null,
        ]);
    }
}
