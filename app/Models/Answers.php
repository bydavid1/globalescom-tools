<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'input_id',
        'body'
    ];
    
    /**Get the user that owns the answer.*/
    public function User() {
        return $this->belongsTo('App\User', 'user_id');
    }
    /**Get the input that the answer is for.*/
    public function Input(){
        return $this->belongsTo('App\Inputs', "input_id");
    }
}
