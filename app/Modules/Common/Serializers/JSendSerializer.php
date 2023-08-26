<?php

namespace App\Modules\Common\Serializers;

use Illuminate\Support\Facades\Storage;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Support\Str;
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
        $resourceKey = str_plural($resourceKey);
        if (mb_strlen(json_encode($data)) > config('app.response_size_limit', 4660001)) {
            $data = $this->uploadResponse([ $resourceKey => $data ]);
            $resourceKey = 'response_file';
        }
        return [
            'status' => 'success',
            'data' => [
                $resourceKey => $data
            ]
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
        $resourceKey = str_singular($resourceKey);
        if (mb_strlen(json_encode($data)) > config('app.response_size_limit', 4660001)) {
            $data = $this->uploadResponse($data);
            $resourceKey = 'response_file';
        }
        return [
            'status' => 'success',
            'data' => [
                $resourceKey => $data
            ]
        ];
    }

    /**
     * Serialize a null item
     *
     * @return array|null
     */
    public function null() :array|null
    {
        return [
            'status' => 'success',
            'data' => null
        ];
    }

    /**
     * Merge includes
     *
     * @param $transformedData
     * @param $includedData
     * @return array
     */
    public function mergeIncludes($transformedData, $includedData) :array
    {
        $includedData = collect($includedData)->flatMap(function ($include, $key) {
            // check for null resource
            if ($include['data'] === null) {
                return [
                    str_singular($key) => null
                ];
            }

            return $include['data'];
        })->toArray();

        return parent::mergeIncludes($transformedData, $includedData);
    }

    private function uploadResponse($data): string
    {
        $key = str_random(40);
        Storage::disk('responses')->put($key, json_encode($data, true));

        return Storage::disk('responses')->temporaryUrl($key, now()->addMinutes(config('app.temporary_url_lifetime', 5)));
    }
}
