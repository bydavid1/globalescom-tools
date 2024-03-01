<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tool_id',
        'section_type',
        'parent_id'
    ];

    /**
     * Get the tools associated with the section
    */
    public function Tools() {
        return $this->belongsTo('App\Tools', "tool_id");
    }

    /**
     * Relation with others sections.
    */
    public function Parent()
    {
        return $this->belongsTo('App\Sections', 'parent_id');
    }

    /**
     * Get sections with parent_id
    */
    public function Subsections()
    {
        return $this->hasMany('App\Sections', 'parent_id');
    }

    /**
     * Get the section type.
     */
    public function Section_type(){
        return  $this->belongsTo('App\Section_types','section_type');
    }

    /**
     * Get the forms associated with the section.
     */
    public function Forms()
    {
        return $this->belongsToMany('App\Forms', 'form_section');
    }
}
