<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing01 extends BaseSparing
{
    use HasFactory;

    protected $table = 'sparing01'; // Nama tabel sparing01
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
        'id' => 'sparing01',
        'nama' => 'Gistex',
        'alamat' => 'Jl. Nanjung No.82, Lagadar, Kec. Margaasih, Kabupaten Bandung, Jawa Barat 40216, Indonesia',
        'Lat' => -6.9374571,
        'Long' => 107.5364919,
        'bakumutu' => [
            'ph' => ['min' => 6, 'max' => 9],
            'cod' => ['min' => 0, 'max' => 115],
            'tss' => ['min' => 0, 'max' => 30],
            'nh3n' => ['min' => 0, 'max' => 8],
            // Tambahkan parameter lain jika diperlukan
        ]
    ];

    public static function getData()
    {
        return self::$data;
    }
}
