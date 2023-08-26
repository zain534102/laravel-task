<?php

namespace App\Modules\Common\Traits;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
trait PaginationTrait
{
    /**
     * @return int
     * @throws BindingResolutionException
     */
    public function getPerPage():int
    {
        $request = Container::getInstance()->make('request');
        if ($request && $request->input('per_page')) {
            return $request->input('per_page');
        }

        return $this->perPage;
    }
}
