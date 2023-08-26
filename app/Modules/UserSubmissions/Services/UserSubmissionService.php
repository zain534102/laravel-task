<?php

namespace App\Modules\UserSubmissions\Services;

use App\Modules\Common\Services\BaseService;
use App\Modules\UserSubmissions\Contracts\Repositories\UserSubmissionRepository;
use App\Modules\UserSubmissions\Requests\CreateUserSubmissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserSubmissionService extends BaseService
{
    /**
     * UserSubmissionService constructor.
     *
     * @param UserSubmissionRepository $userSubmissionRepository
     */
    public function __construct(private readonly UserSubmissionRepository $userSubmissionRepository)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if(Cache::has('user_submission')){
            $userSubmissions = (Cache::get('user_submission'));
            $this->userSubmissionRepository->setModel($userSubmissions);
            return response()->json($this->userSubmissionRepository->transformItem());
        }
        $data = $this->userSubmissionRepository->transformCollection($this->userSubmissionRepository->paginate());
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserSubmissionRequest $request
     * @param array $includes
     * @return JsonResponse
     */
    public function store(CreateUserSubmissionRequest $request, array $includes): JsonResponse
    {
        DB::beginTransaction();
        try {
            $userSubmission = $this->userSubmissionRepository->create($request->validated());
            Cache::put('user_submission',$userSubmission, 10);
            $this->userSubmissionRepository->setModel($userSubmission);
            $data = $this->userSubmissionRepository->transformItem($includes);
            DB::commit();
            return response()->json($data, Response::HTTP_CREATED);
        }
        catch (\Exception $exception){
            Log::info("Error message while creating user submission",['error'=> $exception->getMessage(),'error_file'=>$exception->getFile(),'line'=>$exception->getLine()]);
            DB::rollBack();
            return response()->json(['There is an issue on creation'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
