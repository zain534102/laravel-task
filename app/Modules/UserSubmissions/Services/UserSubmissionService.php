<?php

namespace App\Modules\UserSubmissions\Services;

use App\Modules\Common\Services\BaseService;
use App\Modules\UserSubmissions\Contracts\Repositories\UserSubmissionRepository;
use App\Modules\UserSubmissions\Requests\CreateUserSubmissionRequest;
use App\Modules\UserSubmissions\Requests\UpdateUserSubmissionRequest;
use App\Modules\UserSubmissions\UserSubmission;
use Illuminate\Http\JsonResponse;

class UserSubmissionService extends BaseService
{
   /**
        * @var UserSubmissionRepository
        */
       private $userSubmissionRepository;

       /**
        * UserSubmissionService constructor.
        *
        * @param UserSubmissionRepository $userSubmissionRepository
        */

      public function __construct(UserSubmissionRepository $userSubmissionRepository)
        {
            $this->userSubmissionRepository = $userSubmissionRepository->withQueryBuilder();
        }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
   */
       public function index()
       {
           if (request()->has('all')) {
               $userSubmissions = $this->userSubmissionRepository->get();
           } else {
               $userSubmissions = $this->userSubmissionRepository->paginate();
           }
           $data = $this->userSubmissionRepository->transformCollection($userSubmissions);
           return response()->json($data);
       }

     /**
         * Store a newly created resource in storage.
         *
         * @param CreateUserSubmissionRequest $request
         * @return JsonResponse
         */
        public function store(CreateUserSubmissionRequest $request, array $includes)
        {
            $userSubmission = $this->userSubmissionRepository->create($request->all())
                ->load(includes_to_camel_case($includes));
            $this->userSubmissionRepository->setModel($userSubmission);
            $data = $this->userSubmissionRepository->transformItem($includes);
            return response()->json($data, 201);
        }

        /**
         * Display the specified resource.
         *
         * @param string $userSubmissionId
         * @return JsonResponse
         */
        public function show(string $userSubmissionId)
        {
            $userSubmission = $this->userSubmissionRepository->findByParams(['uuid'=>$userSubmissionId]);
            $this->userSubmissionRepository->setModel($userSubmission);
            $data = $this->userSubmissionRepository->transformItem();
            return response()->json($data);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateUserSubmissionRequest $request
         * @param UserSubmission $userSubmission
         * @return JsonResponse
         */
        public function update(UpdateUserSubmissionRequest $request, UserSubmission $userSubmission,array $includes)
        {
            $this->userSubmissionRepository->setModel($userSubmission);
            $this->userSubmissionRepository->update($request->all());
            $userSubmission->load(includes_to_camel_case($includes));
            $data = $this->userSubmissionRepository->transformItem();
            return response()->json($data);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param UserSubmission $userSubmission
         * @return JsonResponse
         */
        public function destroy(UserSubmission $userSubmission)
        {
            $this->userSubmissionRepository->setModel($userSubmission);
            $this->userSubmissionRepository->delete();
            $data = $this->userSubmissionRepository->transformNull();
            return response()->json($data, 202);
        }
}

