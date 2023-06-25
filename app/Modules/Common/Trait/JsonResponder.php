<?php

namespace App\Modules\Common\Trait;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait JsonResponder
{
    /**
     * @param $exception
     * @return JsonResponse
     */
    public function errorMessage($exception): JsonResponse
    {
        Log::error("error occur",['message'=>$exception->getMessage(),'trace'=>$exception->getTrace(),'file'=>$exception->getFile()]);
        return response()->json(['success'=>false,'message'=>"Server Error",'errors'=>$exception->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
