<?php
namespace App\Transformers;

use App\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    public function transform(Project $project)
    {
        return [
            'project_id' => $project->project_id,
            'project_label' => $project->label
        ];
    }
}
