<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Ambil ID terakhir dari user yang masih tersimpan di database
            $lastUser = User::orderBy('id', 'desc')->first();
            $lastId = $lastUser ? intval(substr($lastUser->id, 3)) : 0;

            // Tambahkan 1 ke ID terakhir untuk membuat ID yang baru
            $newId = $lastId + 1;

            // Set ID userbaru dengan format ptg001 dst
            $user->id = 'ksr' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        });

        // static::creating(function ($buku) {
        //     $buku->id = 'bku' . str_pad(Buku::count() + 1, 4, '0', STR_PAD_LEFT);
        // });
    }

    public function hasRole($role)
    {
        return $this->roles === $role;
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
