<?php

namespace App\Modules\Job\Services;

use App\Models\Job;
use App\Modules\Common\Service\BaseService;
use App\Modules\Job\Contract\JobService as JobServiceContract;
use League\Fractal\TransformerAbstract;
use App\Modules\Job\Transformer\JobTransformer;
class JobService extends BaseService implements JobServiceContract
{

    /**
     * RuleRepository constructor.
     *
     * @param Job $model
     */
    public function __construct(Job $model)
    {
        parent::__construct($model);
    }
    public function getTransformer(): TransformerAbstract
    {
        return new JobTransformer;
    }
    public function getResourceKey(): string
    {
        return 'jobs';
    }
}
