<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $fillable = ['nama', 'no_telepon'];

    public function produkMasuk(): HasMany
    {
        return $this->hasMany(ProdukMasuk::class);
    }
}
