<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing06 extends BaseSparing
{
    use HasFactory;
    protected $table = 'sparing06'; // Nama tabel sparing01
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
        "id" => "sparing06",
        "nama" => "Indotaisei",
        "alamat" => "Kawasan Indotaisei. Blok K/4, Kalihurip, Cikampek, Karawang Regency, West Java 41373, Indonesia",
        "Lat" => -6.4244492,
        "Long" => 107.4187869,
        'bakumutu' => [
            'ph' => ['min' => 6, 'max' => 9],
            'cod' => ['min' => 0, 'max' => 100],
            'tss' => ['min' => 0, 'max' => 150],
            'nh3n' => ['min' => 0, 'max' => 20],
            // Tambahkan parameter lain jika diperlukan
        ]
    ];
    public static function getData()
    {
        return self::$data;
    }
}
