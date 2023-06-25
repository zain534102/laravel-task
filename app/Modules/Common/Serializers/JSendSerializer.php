<?php

namespace App\Modules\Common\Serializers;

use Illuminate\Support\Str;
use League\Fractal\Serializer\DataArraySerializer;

class JSendSerializer extends DataArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data) :array
    {
        $resourceKey = Str::plural($resourceKey);
        return [
            'status' => 'success',
            'data' => [
                $resourceKey => $data
            ],
        ];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data) :array
    {
        $resourceKey = Str::singular($resourceKey);
        return [
            'status' => 'success',
            'data' => [
                $resourceKey => $data
            ],
        ];
    }

    /**
     * Serialize a null item
     *
     * @return array
     */
    public function null() :array
    {
        return [
            'status' => 'success',
            'data' => null,
        ];
    }
}
