<?php

namespace App\Modules\Job\Transformer;

use App\Models\Job;
use League\Fractal\TransformerAbstract;

class JobTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param Job $job
     * @return array
     */
    public function transform(Job $job)
    {
        return $job->toArray();
    }
}
