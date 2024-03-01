<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing04 extends BaseSparing
{
    use HasFactory;

    protected $table = 'sparing04'; // Nama tabel sparing01
    protected $primaryKey = 'id'; // Kolom kunci utama (biasanya 'id')
    public $timestamps = false; // Jika tabel tidak memiliki kolom 'created_at' dan 'updated_at'

    protected $fillable = [
        // Daftar kolom yang dapat diisi secara massal
        'time',
        'cod',
        'tss',
        'ph',
        'nh3n',
        'debit2',
        'debit',
        'bakumutu',
        // Tambahkan kolom lain sesuai kebutuhan
    ];

    protected static $data = [
        "id" => "sparing04",
        "nama" => "PT.INDO-RAMA SYNTHETICS.Tbk, KAB. Bandung Barat",
        "alamat" => "Jl. Batujajar Km 5.5 Komplek Giri Asih No 9, Samping, Giriasih, Batujajar, West Bandung Regency, West Java 40561, Indonesia",
        "Lat" => -6.8953855,
        "Long" => 107.4959834,
        'bakumutu' => [
            'ph' => ['min' => 6, 'max' => 9],
            'cod' => ['min' => 0, 'max' => 125],
            'tss' => ['min' => 0, 'max' => 40],
            'nh3n' => ['min' => 0, 'max' => 20],
            // Tambahkan parameter lain jika diperlukan
        ]
    ];
    public static function getData()
    {
        return self::$data;
    }

}
