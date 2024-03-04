<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**Get  the section that owns the tool.*/
    public function Sections(){
        return $this->hasMany('App\Sections', 'tool_id');
    }
}
