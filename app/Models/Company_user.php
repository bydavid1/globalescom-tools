<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'user_id'
    ];

    /**
     * Get the user that owns the company user.
     */
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the company that owns the company user.
     */
    public function Company()
    {
        return $this->belongsTo('App\Companies', 'company_id');
    }



}
