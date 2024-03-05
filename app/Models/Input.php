<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'form_id',
        'input_type_id',
        'label',
        'placeholder',
        'options'
    ];


    public function form() {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function type(){
        return $this->belongsTo(InputType::class, 'input_type_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'input_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'input_id');
    }
}
