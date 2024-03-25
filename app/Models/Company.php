<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    public static string $mediaPath = 'empresas/';

    protected  $fillable = ['name', 'logo'];

    protected function logo() : Attribute
    {
        return Attribute::make(
            get: fn (string|null $value) => $value ? Storage::url($this::$mediaPath . $value) : null
        );
    }

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
