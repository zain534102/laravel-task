<?php

namespace Tests\Unit\Job;

use App\Models\Job;
use App\Modules\Job\Contract\JobService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;

class JobTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;
    use WithFaker;
    use CreatesApplication;

    const JOBS_TABLE = 'jobs';
    private JobService $jobService;

    public function setUp(): void
    {
        parent::setUp();
        $this->jobService = resolve(JobService::class);
    }


    public function test_it_can_create_job()
    {
        $data = Job::factory()->make()->toArray();
        $job = $this->jobService->create($data);
        $this->assertInstanceOf(Job::class, $job);
        $this->assertDatabaseHas(self::JOBS_TABLE,$data);
    }
    public function test_it_can_update_job(){
        $job = Job::factory()->create();
        $jobData = Job::factory()->make()->toArray();
        $this->jobService->setModel($job);
        $this->jobService->update($jobData);
        $this->assertDatabaseHas(self::JOBS_TABLE, array_merge($jobData, [
            'id' => $job->id
        ]));
    }
    public function test_it_can_find_job_by_id(){
        $job = Job::factory()->create();
        $_job = $this->jobService->findById($job->id);
        $this->assertInstanceOf(Job::class, $_job);
        $this->assertEquals($job->id, $_job->id);
    }
    public function test_it_can_paginate_job(){
        $_job = Job::factory()->create();
        $jobs = $this->jobService->paginate(10);
        $this->assertInstanceOf(LengthAwarePaginator::class, $jobs);
        $this->assertCount(1, $jobs->items());
        collect($jobs->items())->each(function ($job) use ($_job) {
            $this->assertInstanceOf(Job::class, $job);
            $this->assertEquals($job->id, $_job->id);
        });
    }
    public function test_it_can_delete_job_by_id(){
        $job = Job::factory()->create();
        $_job = Job::factory()->create();
        $this->jobService->setModel($job);
        $this->jobService->delete();
        $this->assertDatabaseMissing(self::JOBS_TABLE,[
            'id'=>$job->id
        ]);
        $this->assertDatabaseHas(self::JOBS_TABLE,[
            'id'=>$_job->id
        ]);
    }
}
