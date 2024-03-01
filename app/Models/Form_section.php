<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_section extends Model
{
    use HasFactory;
    protected $fillable = [ 'form_id', 'section_id'];

    /** Get the form that owns this section */
    public function Form() {
        return $this->belongsTo('App\Forms', 'form_id');
    }

    /** Get the section that is in this form-section. */
    public function Section(){
        return $this->belongsTo('App\Sections','section_id');
    }
}
