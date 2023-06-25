<?php

namespace Tests\Feature\Job;

use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class JobTest extends TestCase
{
    const JOBS_TABLE = 'jobs';
    public function test_create_job(){
        $data = Job::factory()->make()->toArray();
        $response = $this->post(route('jobs.store'),$data);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                "status",
                "data" => [
                    "job" => [
                        "id", 'title', 'description',
                    ]
                ]
            ]);
        $this->assertDatabaseHas(self::JOBS_TABLE, $data);
    }
    public function test_get_job(): void
    {
        $data = Job::factory()->count(10)->create();
        $response = $this->get(route('jobs.index'));
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "status",
                "data" => [
                    "jobs"=>[
                        "*" => [
                            "id", 'title', 'description',
                        ]
                    ]
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_delete_job(): void
    {
        $job = Job::factory()->create();
        $params = [
            'job'=>$job->id,
        ];
        $response = $this->delete(route('jobs.destroy',$params));
        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            "status",
            "data"
        ]);
    }

    /**
     * @return void
     */
    public function test_update_job(): void
    {
        $job = Job::factory()->create();
        $params = [
            'job'=>$job->id
        ];
        $response = $this->put(route('jobs.update',$params),$job->toArray());
        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
           "status",
           "data"=>[
               "job"=>[
                   "id","title","description"
               ]
           ]
        ]);
        $this->assertDatabaseHas(self::JOBS_TABLE, array_merge($job->toArray(), [
            'id' => $job->id
        ]));
    }

    /**
     * @return void
     */
    public function test_it_show(): void
    {
        $job = Job::factory()->create();
        $params = [
            'job'=>$job->id,
        ];
        $response = $this->get(route('jobs.show.ajax',$params));
        $response->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            "status",
            "data"=>[
                "job"=>[
                    "id","title","description"
                ]
            ]
        ]);
        $this->assertDatabaseHas(self::JOBS_TABLE, array_merge($job->toArray(), [
            'id' => $job->id
        ]));
    }

    /**
     * @return void
     */
    public function test_index_view(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('pages.jobs.index');
    }

    /**
     * @return void
     */
    public function test_show_view(): void
    {
        $job = Job::factory()->create();
        $response = $this->get(route('jobs.show',['job'=>$job->id]));
        $response->assertStatus(200)
            ->assertViewIs('pages.jobs.show');
    }
}
