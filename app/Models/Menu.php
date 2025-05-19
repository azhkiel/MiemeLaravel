<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey = 'kodemenu';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'menu';
    protected $fillable = ['kodemenu','namamenu','harga','kategori','deskripsi','gambar'];
    public function charts()
    {
        return $this->hasMany(Chart::class, 'kodemenu', 'kodemenu');
    }
}
