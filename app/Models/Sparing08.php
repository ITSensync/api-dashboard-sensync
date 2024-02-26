<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing08 extends Model
{
    use HasFactory;
    protected $table = 'sparing08'; // Nama tabel sparing01
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
        "id" => "sparing08",
        "nama" => "PT. Papyrus Sakti Paper Mill",
        "alamat" => "Jl. Raya Banjaran Km. 16.2, Banjaran, Batukarut, Kec. Arjasari, Kabupaten Bandung, Jawa Barat 40379",
        "Lat" => -7.0384787,
        "Long" => 107.5906626
    ];

    public static function getData()
    {
        return self::$data;
    }
}
