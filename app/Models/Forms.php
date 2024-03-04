<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    /**
     * Get the inputs for the form.
     */
    public function Inputs()
    {
        return $this->hasMany('App\Inputs');
    }

    /**
     * Get the sections associated with the form.
     */
    public function Sections()
    {
        return $this->belongsToMany('App\Sections', 'form_section');
    }
}
