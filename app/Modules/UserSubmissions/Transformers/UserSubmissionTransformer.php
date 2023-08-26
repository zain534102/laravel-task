<?php

namespace App\Modules\UserSubmissions\Transformers;

use App\Modules\UserSubmissions\UserSubmission;
use League\Fractal\TransformerAbstract;

class UserSubmissionTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param UserSubmission $userSubmission
     * @return array
     */
    public function transform(UserSubmission $userSubmission)
    {
        return $userSubmission->toArray();
    }
}
