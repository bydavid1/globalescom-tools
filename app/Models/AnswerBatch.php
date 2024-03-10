<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerBatch extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
