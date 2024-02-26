<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing10 extends Model
{
    use HasFactory;
    protected $table = 'sparing10'; // Nama tabel sparing01
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
        // Tambahkan kolom lain sesuai kebutuhan
    ];

    protected static $data = [
        "id" => "sparing10",
            "nama" => "PT. Sinar Pangjaya Mulia",
            "alamat" => "Jl. Mahar Martanegara No.175, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40522",
            "Lat" => -6.5671703,
            "Long" => 106.5889997
    ];

    public static function getData()
    {
        return self::$data;
    }
}
