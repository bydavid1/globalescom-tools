<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tool_id',
        'section_type',
        'parent_id'
    ];


    public function tool() {
        return $this->belongsTo(Tool::class, "tool_id");
    }

    /**
     * Relation with others sections.
    */
    public function parent()
    {
        return $this->belongsTo(Section::class, 'parent_id');
    }

    /**
     * Get sections with parent_id
    */
    public function children()
    {
        return $this->hasMany(Section::class, 'parent_id');
    }

    public function sectionType(){
        return  $this->belongsTo(SectionType::class, 'section_type_id');
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'form_section');
    }

    public function answerBatches()
    {
        return $this->hasMany(AnswerBatch::class);
    }
}
