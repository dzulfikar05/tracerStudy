<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = "answers";

    public function filler_superior()
    {
        return $this->belongsTo(Superior::class, 'filler_id');
    }

    public function filler_alumni()
    {
        return $this->belongsTo(Alumni::class, 'filler_id');
    }
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
