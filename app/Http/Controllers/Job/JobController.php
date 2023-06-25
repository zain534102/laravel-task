<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Modules\Job\Contract\JobService;
use App\Modules\Job\Request\JobRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function __construct(public JobService $jobService){
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try{
            $jobs = $this->jobService->paginate(10);
            $jobs = $this->jobService->transformCollection($jobs);
            return response()->json($jobs,Response::HTTP_OK);
        }
        catch (Exception $exception){
            return $this->errorMessage($exception);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->jobService->showPage(pageName: 'jobs.create',callback: []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request): JsonResponse
    {
        try{
            $job = $this->jobService->create($request->validated());
            $this->jobService->setModel($job);
            $data = $this->jobService->transformItem();
            return response()->json(Arr::add($data,'message',"Job Created Successfully"), Response::HTTP_CREATED);
        }
        catch (Exception $exception){
            return $this->errorMessage($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job): JsonResponse|View
    {
        return $this->jobService->showPage(pageName: 'jobs.show',callback: []);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->jobService->showPage(pageName: 'jobs.edit',callback: []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $job): JsonResponse
    {
        try{
            $this->jobService->setModel($job);
            $this->jobService->update($request->validated());
            $data = $this->jobService->transformItem();
            return response()->json(Arr::add($data,'message',"Job Updated Successfully"),Response::HTTP_CREATED);
        }
        catch (Exception $exception){
            return $this->errorMessage($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @throws Exception
     */
    public function destroy(Job $job): \Illuminate\Foundation\Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try{
            $this->jobService->setModel($job);
            $this->jobService->delete();
            $data = $this->jobService->transformNull();
            return response(Arr::add($data,'message',"Job Deleted Successfully"), Response::HTTP_CREATED);
        }
        catch (Exception $exception){
            return $this->errorMessage($exception);
        }
    }
    /**
     * Display the specified resource.
     */
    public function showJob(Job $job): JsonResponse|View
    {
        try{
            $blog = $this->jobService->findById($job->id);
            $this->jobService->setModel($blog);
            $data = $this->jobService->transformItem();
            return response()->json($data,Response::HTTP_OK);
        }
        catch (Exception $exception){
            return $this->errorMessage($exception);
        }
    }
}
