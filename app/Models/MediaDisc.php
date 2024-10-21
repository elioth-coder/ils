<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaDisc extends Model
{
    use HasFactory;
    protected $table = 'media_discs';
    protected $guarded = ['id','created_at','updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ir_number = DB::raw('UUID_SHORT()');
        });
    }
}
