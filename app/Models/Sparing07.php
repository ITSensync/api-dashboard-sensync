<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing07 extends Model
{
    use HasFactory;
    protected $table = 'sparing07'; // Nama tabel sparing01
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
        "id" => "sparing07",
        "nama" => "PT Daliatex Kusuma",
        "alamat" => " Jalan Mochammad Toha KM.7,3 No.307, Citeureup, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257",
        "Lat" => -6.9801221,
        "Long" => 107.6185288
    ];

    public static function getData()
    {
        return self::$data;
    }
}
