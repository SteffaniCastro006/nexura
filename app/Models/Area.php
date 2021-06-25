<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public static function forDropdown(){
    	return self::all()->pluck('name', 'id');
    }
}