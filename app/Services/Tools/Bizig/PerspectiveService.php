<?php
namespace App\Services\Tools\Bizig;

use App\Models\Form;
use App\Models\Section;
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
}
