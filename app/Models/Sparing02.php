<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing02 extends BaseSparing
{
    use HasFactory;
    protected $table = 'sparing02'; // Nama tabel sparing01
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
    ];

    protected static $data = [
        "id" => "sparing02",
        "nama" => "PT.INDO-RAMA SYNTHETICS.Tbk",
        "alamat" => "Jl. Industri Ubrug, Kembangkuning, Purwakarta Regency, West Java, Indonesia",
        "Lat" => -6.5531083,
        "Long" => 107.4101544,
        'bakumutu' => [
            'ph' => ['min' => 6, 'max' => 9],
            'cod' => ['min' => 0, 'max' => 125],
            'tss' => ['min' => 0, 'max' => 40],
            'nh3n' => ['min' => 0, 'max' => 20],
            // Tambahkan parameter lain jika diperlukan
        ]
    ];
}
