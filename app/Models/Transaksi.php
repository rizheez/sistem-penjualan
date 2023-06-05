<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $guarded = ['id'];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trx) {
            // Ambil ID terakhir dari user yang masih tersimpan di database
            $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();
            $lastId = $lastTransaksi ? intval(substr($lastTransaksi->id, 3)) : 0;

            // Tambahkan 1 ke ID terakhir untuk membuat ID yang baru
            $newId = $lastId + 1;

            // Set ID userbaru dengan format ptg001 dst
            $trx->id = 'trx' . str_pad($newId, 5, '0', STR_PAD_LEFT);
        });

        // static::creating(function ($buku) {
        //     $buku->id = 'bku' . str_pad(Buku::count() + 1, 4, '0', STR_PAD_LEFT);
        // });
    }

    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
