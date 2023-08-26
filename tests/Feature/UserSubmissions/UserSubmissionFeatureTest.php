<?php

namespace Tests\Feature\UserSubmissions;

use App\Modules\UserSubmissions\UserSubmission;
use Tests\TestCase;

class UserSubmissionFeatureTest extends TestCase
{
    const USER_SUBMISSIONS_TABLE = 'user_submissions';

    /** @test */
    public function it_can_create_user_submission()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        $this->post(route('user-submissions.store'), $data)
            ->assertStatus(201)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_find_all_user_submission()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        factory(UserSubmission::class)->create($data);
        $this->get(route('user-submissions.index', ['all' => true]))
            ->assertStatus(200)
            ->assertJsonFragment($data)
            ->assertJsonMissing([
                'pagination' => [
                    'total' => 1,
                    'count' => 1,
                    'per_page' => 15,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => []
                ]
            ]);
    }

    /** @test */
    public function it_can_paginate_user_submission()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        factory(UserSubmission::class)->create($data);
        $this->get(route('user-submissions.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'pagination' => [
                    'total' => 1,
                    'count' => 1,
                    'per_page' => 15,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => []
                ]
            ]);
    }

    /** @test */
    public function it_can_find_user_submission_by_id()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        $userSubmission = factory(UserSubmission::class)->create($data);
        $this->get(route('user-submissions.show', $userSubmission))
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_update_the_user_submission()
    {
        $data = factory(UserSubmission::class)->make()->toArray();
        $userSubmission = factory(UserSubmission::class)->create();
        $this->put(route('user-submissions.update', $userSubmission), $data)
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_the_user_submission()
    {
        $userSubmission = factory(UserSubmission::class)->create();
        $this->delete(route('user-submissions.destroy', $userSubmission))
            ->assertStatus(202)
            ->assertExactJson([
                'status' => 'success',
                'data' => null
            ]);
        $this->assertDatabaseMissing(self::USER_SUBMISSIONS_TABLE, [
            'id' => $userSubmission->id
        ]);
    }
}

