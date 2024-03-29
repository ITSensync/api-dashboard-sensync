<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing05 extends Model
{
    use HasFactory;
    protected $table = 'sparing05'; // Nama tabel sparing01
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
        "id" => "sparing05",
        "nama" => "Kawasan Berikat Pt Besland Indo",
        "alamat" => "Wisma Bukit Indah Block L Kawasan Kota Bukit Indah Cinangka Purwakarta, Dangdeur, Bungursari, Purwakarta Regency, West Java 41181, Indonesia",
        "Lat" => -6.4493131,
        "Long" => 107.4572677
    ];

    public static function getData()
    {
        return self::$data;
    }
}
