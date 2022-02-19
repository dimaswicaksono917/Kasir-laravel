<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $fillable = ['nama_menu','harga','deskripsi','ketersediaan'];

    public function absen(){
        return $this->hasmany(Transaksi::class);
    }
}
