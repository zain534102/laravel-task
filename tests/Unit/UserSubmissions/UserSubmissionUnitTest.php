<?php

namespace Tests\Unit\UserSubmissions;

use App\Modules\UserSubmissions\Contracts\Repositories\UserSubmissionRepository;
use App\Modules\UserSubmissions\UserSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserSubmissionUnitTest extends TestCase
{
    const USER_SUBMISSIONS_TABLE = 'user_submissions';

    /**
     * @var UserSubmissionRepository
     */
    private $userSubmissionRepository;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->userSubmissionRepository = $this->app->make(UserSubmissionRepository::class);
    }

    /** @test */
    public function it_can_create_user_submission()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        $userSubmission = $this->userSubmissionRepository->create($data);
        $this->assertInstanceOf(UserSubmission::class, $userSubmission);
        $this->assertDatabaseHas(self::USER_SUBMISSIONS_TABLE, $data);
    }

    /** @test */
    public function it_can_find_user_submission_by_id()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        factory(UserSubmission::class)->create();
        $_userSubmission = $this->userSubmissionRepository->findById($userSubmission->id);
        $this->assertInstanceOf(UserSubmission::class, $_userSubmission);
        $this->assertEquals($userSubmission->id, $_userSubmission->id);
    }

    /** @test */
    public function it_can_find_user_submissions()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        $userSubmissions = $this->userSubmissionRepository->get();
        $this->assertInstanceOf(Collection::class, $userSubmissions);
        $this->assertCount(1, $userSubmissions);
        $userSubmissions->each(function ($_userSubmission) use ($userSubmission) {
            $this->assertInstanceOf(UserSubmission::class, $_userSubmission);
            $this->assertEquals($userSubmission->id, $_userSubmission->id);
        });
    }

    /** @test */
    public function it_can_paginate_user_submissions()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        $userSubmissions = $this->userSubmissionRepository->paginate();
        $this->assertInstanceOf(LengthAwarePaginator::class, $userSubmissions);
        $this->assertCount(1, $userSubmissions->items());
        collect($userSubmissions->items())->each(function ($_userSubmission) use ($userSubmission) {
            $this->assertInstanceOf(UserSubmission::class, $_userSubmission);
            $this->assertEquals($userSubmission->id, $_userSubmission->id);
        });
    }

    /** @test */
    public function it_can_update_the_user_submission()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        $data = factory(UserSubmission::class)->make()->toArray();
        $this->userSubmissionRepository->setModel($userSubmission);
        $this->userSubmissionRepository->update($data);
        $this->assertDatabaseHas(self::USER_SUBMISSIONS_TABLE, array_merge($data, [
            'id' => $userSubmission->id
        ]));
    }

    /** @test */
    public function it_can_delete_the_user_submission()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        $_userSubmission = factory(UserSubmission::class)->create();
        $this->userSubmissionRepository->setModel($userSubmission);
        $this->userSubmissionRepository->delete();
        $this->assertDatabaseMissing(self::USER_SUBMISSIONS_TABLE, [
            'id' => $userSubmission->id
        ]);
        $this->assertDatabaseHas(self::USER_SUBMISSIONS_TABLE, [
            'id' => $_userSubmission->id
        ]);
    }
}
