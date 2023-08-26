<?php

namespace App\Modules\UserSubmissions\Repositories;

use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\UserSubmissions\Contracts\Repositories\UserSubmissionRepository as UserSubmissionRepositoryContract;
use App\Modules\UserSubmissions\Transformers\UserSubmissionTransformer;
use App\Modules\UserSubmissions\UserSubmission;
use League\Fractal\TransformerAbstract;

class UserSubmissionRepository extends BaseRepository implements UserSubmissionRepositoryContract
{
    /**
     * UserSubmissionRepository constructor.
     *
     * @param UserSubmission $model
     */
    public function __construct(UserSubmission $model)
    {
        parent::__construct($model);
    }

    /**
     * @return TransformerAbstract
     */
    public function getTransformer(): TransformerAbstract
    {
        return new UserSubmissionTransformer;
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'user_submissions';
    }
}

