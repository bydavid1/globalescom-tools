<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected  $fillable = ['name'];

    /**
     * Get the users associated with the company.
     */
    public function Company_user()
    {
        return $this->hasMany('App\CompanyUser', 'user_id');
    }
    
}
