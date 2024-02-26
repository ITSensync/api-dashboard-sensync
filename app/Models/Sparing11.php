<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing11 extends Model
{
    use HasFactory;
    protected $table = 'sparing11'; // Nama tabel sparing01
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
        "id" => "sparing11",
        "nama" => "Lucky Print Abadi",
        "alamat" => "Jl. Perjuangan, RT.03/RW.06, Sukadanau, Kec. Cikarang Bar., Kabupaten Bekasi, Jawa Barat 17520",
        "Lat" => -6.5791553,
        "Long" =>106.5895596
    ];

    public static function getData()
    {
        return self::$data;
    }
}
