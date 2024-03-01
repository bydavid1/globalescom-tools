<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inputs extends Model
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

    /**
     * Get the forms for the input.
     */
    public function Forms() {
        return $this->belongsTo('App\Forms', 'form_id');  
    }

    /**
     * Get the Input_types of the input.
     */
    public function Input_type(){
        return $this->belongsTo('App\Input_types', 'input_type_id');
    }

    /**
     * Get the answers for the input.
     */
    public function Answers()
    {
        return $this->hasMany('App\Answers');
    }
}
