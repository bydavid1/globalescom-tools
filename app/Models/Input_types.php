<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input_types extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    /**
     * Get the inputs.
     */
    public function Inputs()
    {
        return $this->hasMany('App\Inputs', 'input_type_id');
    }
}
