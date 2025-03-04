<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "the_loai";
    protected $primaryKey = "id";
    protected $fillable = ['id', 'ten_the_loai'];
    public $timestamps = false;
}
