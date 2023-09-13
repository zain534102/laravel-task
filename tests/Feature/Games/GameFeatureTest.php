<?php

namespace Tests\Feature\Games;

use App\Modules\Games\Game;
use Tests\TestCase;

class GameFeatureTest extends TestCase
{
    const GAMES_TABLE = 'games';

    /** @test */
    public function it_can_create_game()
    {
        $data = factory(Game::class)->make()->toArray();
        $this->post(route('games.store'), $data)
            ->assertStatus(201)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_find_all_game()
    {
        $data = factory(Game::class)->make()->toArray();
        factory(Game::class)->create($data);
        $this->get(route('games.index', ['all' => true]))
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
    public function it_can_paginate_game()
    {
        $data = factory(Game::class)->make()->toArray();
        factory(Game::class)->create($data);
        $this->get(route('games.index'))
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
    public function it_can_find_game_by_id()
    {
        $data = factory(Game::class)->make()->toArray();
        $game = factory(Game::class)->create($data);
        $this->get(route('games.show', $game))
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_update_the_game()
    {
        $data = factory(Game::class)->make()->toArray();
        $game = factory(Game::class)->create();
        $this->put(route('games.update', $game), $data)
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_the_game()
    {
        $game = factory(Game::class)->create();
        $this->delete(route('games.destroy', $game))
            ->assertStatus(202)
            ->assertExactJson([
                'status' => 'success',
                'data' => null
            ]);
        $this->assertDatabaseMissing(self::GAMES_TABLE, [
            'id' => $game->id
        ]);
    }
}

