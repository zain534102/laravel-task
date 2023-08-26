<?php

if (!function_exists('includes_to_camel_case')) {
    /**
     * Reformat includes to camel-case
     *
     * @param array $includes
     * @return array
     */
    function includes_to_camel_case(array $includes)
    {
        return collect($includes)->map(function ($include) {
            $include = explode('.', $include);

            return collect($include)->map(function ($include) {
                return camel_case($include);
            })->implode('.');
        })->toArray();
    }
}
