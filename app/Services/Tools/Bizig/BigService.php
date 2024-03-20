<?php
namespace App\Services\Tools\Bizig;

use App\Models\Form;
use App\Models\Section;
use App\Models\SectionType;

class BigService
{
    public function createBig(string $name, int $parent_id, int $companyId) : Section
    {
        $sectionTypeId = SectionType::where('name', 'big')->first()->id;

        $parent = Section::findOrFail($parent_id);

        $big = new Section();
        $big->name = $name;
        $big->section_type_id = $sectionTypeId;
        $big->tool_id = 1; // TODO: Change this to a dynamic value
        $big->company_id = $companyId;
        $big->parent_id = $parent->id;
        $big->save();

        $form = Form::find(1); // TODO: Change this to a dynamic value
        $big->forms()->attach($form);

        return $big;
    }
}
