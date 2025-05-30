<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['username','fullname','password','phone','role','password'];
    protected $hidden = ['password',];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function charts()
    {
        return $this->hasMany(Chart::class);
    }

    /**
     * Relasi ke model Order
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
