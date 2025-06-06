<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = "alumnis";

    protected static $prodi = [
        'D4 Teknik Informatika',
        'D4 Sistem Informasi Bisnis',
        'D2 PPLS',
        'S2 MRTI',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
            if (empty($model->updated_at)) {
                $model->updated_at = now();
            }
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    public static function getProdi()
    {
        return self::$prodi;
    }

    public function superior()
    {
        return $this->belongsTo(Superior::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
