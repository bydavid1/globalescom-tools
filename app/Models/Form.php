<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];


    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'form_section');
    }
}
