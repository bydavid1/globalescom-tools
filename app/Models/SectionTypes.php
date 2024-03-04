<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTypes extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
    ];

    /**Get the sections */
    public function Sections() {
        return  $this->hasMany('App\Sections', 'section_type');
    }
}
