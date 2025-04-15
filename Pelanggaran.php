<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggaran extends Model

{
    use HasFactory;

 protected $fillable = [
    'jenis',
    'konsekuensi',
    'poin',

 ];
}
