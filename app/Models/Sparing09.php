<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing09 extends Model
{
    use HasFactory;
    protected $table = 'sparing09'; // Nama tabel sparing01
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
        "id" => "sparing09",
        "nama" => "PT. BINTANG CIPTAPERKASA",
        "alamat" => "Jl. Leuwi Dulang No.24, Sukamaju, Kec. Majalaya, Kabupaten Bandung, Jawa Barat 40392",
        "Lat" => -7.0465691,
        "Long" => 107.7506977
    ];

    public static function getData()
    {
        return self::$data;
    }
}
