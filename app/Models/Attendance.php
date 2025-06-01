<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Definisikan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'attendances';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'attendance_date',
        'status',
        'image',
        'shift',
        'attendance_time',
        'checkout_time',
        'checkout_image',
        'duration',
        'salary',
    ];

    // Menambahkan casting untuk tanggal
    protected $casts = [
        'attendance_date' => 'datetime', // Otomatis di-cast menjadi Carbon instance
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
