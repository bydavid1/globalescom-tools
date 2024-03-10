<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public static string $mediaPath = 'empresas/';

    protected  $fillable = ['name'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'company_user');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'company_tool');
    }

    public function answerBatches()
    {
        return $this->hasMany(AnswerBatch::class);
    }
}
