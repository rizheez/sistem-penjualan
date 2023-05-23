<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'kategori',
        'harga_beli',
        'harga_beli'
    ];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            // Ambil ID terakhir dari produk yang masih tersimpan di database
            $lastProduk = Produk::orderBy('id', 'desc')->first();
            $lastId = $lastProduk ? intval(substr($lastProduk->id, 3)) : 0;

            // Tambahkan 1 ke ID terakhir untuk membuat ID yang baru
            $newId = $lastId + 1;

            // Set ID Produkbaru dengan format ptg001 dst
            $produk->id = 'prd' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        });

        // static::creating(function ($buku) {
        //     $buku->id = 'bku' . str_pad(Buku::count() + 1, 4, '0', STR_PAD_LEFT);
        // });
    }

    public function produkMasuk(): HasMany
    {
        return $this->hasMany(ProdukMasuk::class);
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
