<?php

namespace Tests\Feature\Players;

use App\Modules\Players\Player;
use Tests\TestCase;

class PlayerFeatureTest extends TestCase
{
    const PLAYERS_TABLE = 'players';

    /** @test */
    public function it_can_create_player()
    {
        $data = factory(Player::class)->make()->toArray();
        $this->post(route('players.store'), $data)
            ->assertStatus(201)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_find_all_player()
    {
        $data = factory(Player::class)->make()->toArray();
        factory(Player::class)->create($data);
        $this->get(route('players.index', ['all' => true]))
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
    public function it_can_paginate_player()
    {
        $data = factory(Player::class)->make()->toArray();
        factory(Player::class)->create($data);
        $this->get(route('players.index'))
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
    public function it_can_find_player_by_id()
    {
        $data = factory(Player::class)->make()->toArray();
        $player = factory(Player::class)->create($data);
        $this->get(route('players.show', $player))
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_update_the_player()
    {
        $data = factory(Player::class)->make()->toArray();
        $player = factory(Player::class)->create();
        $this->put(route('players.update', $player), $data)
            ->assertStatus(200)
            ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_the_player()
    {
        $player = factory(Player::class)->create();
        $this->delete(route('players.destroy', $player))
            ->assertStatus(202)
            ->assertExactJson([
                'status' => 'success',
                'data' => null
            ]);
        $this->assertDatabaseMissing(self::PLAYERS_TABLE, [
            'id' => $player->id
        ]);
    }
}

