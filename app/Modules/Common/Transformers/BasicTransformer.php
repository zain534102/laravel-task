<?php

namespace App\Modules\Common\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class BasicTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param Model $model
     * @return array
     */
    public function transform(Model $model):array
    {
        return $model->toArray();
    }
}
