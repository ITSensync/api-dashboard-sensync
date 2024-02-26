<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparing01 extends Model
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
        // Tambahkan kolom lain sesuai kebutuhan
    ];

    protected static $data = [
        'id' => 'sparing01',
        'nama' => 'PT Gistex Textile Division',
        'alamat' => 'Jl. Nanjung No.82, Lagadar, Kec. Margaasih, Kabupaten Bandung, Jawa Barat 40216, Indonesia',
        'Lat' => -6.9374571,
        'Long' => 107.5364919
    ];

    public static function getData()
    {
        return self::$data;
    }
}
