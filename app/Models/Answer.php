<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'answer_batch_id',
        'input_id',
        'body'
    ];

    public function batch()
    {
        return $this->belongsTo(AnswerBatch::class, "answer_batch_id");
    }

    public function input()
    {
        return $this->belongsTo(Input::class, "input_id");
    }
}
