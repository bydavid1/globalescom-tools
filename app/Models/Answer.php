<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'input_id',
        'body'
    ];

    public function batch()
    {
        return $this->belongsTo(AnswerBatch::class);
    }

    public function input(){
        return $this->belongsTo(Input::class, "input_id");
    }
}
