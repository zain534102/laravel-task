<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Modules\UserSubmissions\Requests\CreateUserSubmissionRequest;
use App\Modules\UserSubmissions\Requests\UpdateUserSubmissionRequest;
use App\Modules\UserSubmissions\Services\UserSubmissionService;
use App\Modules\UserSubmissions\UserSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserSubmissionController extends Controller
{

    /**
     * @var array
     */
    private array $includes;

    /**
     * UserSubmissionController constructor.
     *
     * @param UserSubmissionService $userSubmissionService
     * @param Request $request
     */
    public function __construct(Request $request, private readonly UserSubmissionService $userSubmissionService)
    {
        $this->includes = $request->has('include') ? explode(',', $request->input('include')) : [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->userSubmissionService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserSubmissionRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserSubmissionRequest $request): JsonResponse
    {
       return $this->userSubmissionService->store($request,$this->includes);
    }
}
