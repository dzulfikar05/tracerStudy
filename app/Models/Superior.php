<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Superior extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = "superiors";


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
