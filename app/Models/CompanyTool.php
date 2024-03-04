<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTool extends Model
{
    use HasFactory;
    protected $table = [
        'company_id',
        'tool_id'
    ];
    /** Get  the company that owns tool. */
    public function Company() {
        return $this->belongsTo('App\Companies', "company_id");
    }

    /*Get the tool that is owned by a company. **/
    public function Tool(){
        return $this->belongsToMany('App\Tools',"tool_id");
    }
}
