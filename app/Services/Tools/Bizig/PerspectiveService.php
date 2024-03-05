<?php
namespace App\Services\Tools\Bizig;

use App\Models\Form;
use App\Models\Section;
use Illuminate\Support\Collection;

class PerspectiveService
{
    public function getPerspectives() {
        $perspectives = Section::whereRelation('sectionType', 'name', 'perspective')->get();

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
