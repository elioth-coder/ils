<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Research extends Model
{
    use HasFactory;
    protected $table = 'researches';
    protected $guarded = ['id','created_at','updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ir_number = DB::raw('UUID_SHORT()');
        });
    }
}
