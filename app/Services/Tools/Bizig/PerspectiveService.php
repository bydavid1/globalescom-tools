<?php
namespace App\Services\Tools\Bizig;

use App\Models\Form;
use App\Models\Section;
use App\Models\SectionType;
use Illuminate\Support\Collection;

class PerspectiveService
{
    public function getPerspectives(int $companyId) : Collection
    {
        $perspectives = Section::whereRelation('sectionType', 'name', 'perspective')->where('company_id', $companyId)->get();


        return $perspectives;
    }

    public function getPerspective($id) : Section
    {
        $perspective = Section::whereRelation('sectionType', 'name', 'perspective')
            ->where('id', $id)
            ->first();

        return $perspective;
    }

    public function createPerspective(string $name, string $accentColor, int $companyId) : Section
    {
        $sectionTypeId = SectionType::where('name', 'perspective')->first()->id;

        $perspective = new Section();
        $perspective->name = $name;
        $perspective->data = json_encode(['accent_color' => $accentColor]);
        $perspective->section_type_id = $sectionTypeId;
        $perspective->tool_id = 1; // TODO: Change this to a dynamic value
        $perspective->company_id = $companyId;
        $perspective->save();

        $form = Form::find(1); // TODO: Change this to a dynamic value
        $perspective->forms()->attach($form);

        return $perspective;
    }
}
