<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukMasuk extends Model
{
    use HasFactory;

    protected $table = 'produk_masuk';
    protected $fillable = ['produk_id', 'supplier_id', 'tangal_masuk', 'jumlah'];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
