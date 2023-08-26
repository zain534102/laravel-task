<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Modules\UserSubmissions\Requests\CreateUserSubmissionRequest;
use App\Modules\UserSubmissions\Requests\UpdateUserSubmissionRequest;
use App\Modules\UserSubmissions\Services\UserSubmissionService;
use App\Modules\UserSubmissions\UserSubmission;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->userSubmissionService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserSubmissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserSubmissionRequest $request)
    {
       return $this->userSubmissionService->store($request,$this->includes);
    }

    /**
     * Display the specified resource.
     *
     * @param string $userSubmissionId
     * @return \Illuminate\Http\Response
     */
    public function show(string $userSubmissionId)
    {
       return $this->userSubmissionService->show($userSubmissionId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserSubmissionRequest $request
     * @param UserSubmission $userSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserSubmissionRequest $request, UserSubmission $userSubmission)
    {
         return $this->userSubmissionService->update($request,$userSubmission,$this->includes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserSubmission $userSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSubmission $userSubmission)
    {
        return $this->userSubmissionService->destroy($userSubmission);
    }
}
