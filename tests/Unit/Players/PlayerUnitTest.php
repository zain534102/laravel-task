<?php

namespace Tests\Unit\Players;

use App\Modules\Players\Contracts\Repositories\PlayerRepository;
use App\Modules\Players\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PlayerUnitTest extends TestCase
{
    const PLAYERS_TABLE = 'players';

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->playerRepository = $this->app->make(PlayerRepository::class);
    }

    /** @test */
    public function it_can_create_player()
    {
        $data = factory(Player::class)->make()->toArray();
        $player = $this->playerRepository->create($data);
        $this->assertInstanceOf(Player::class, $player);
        $this->assertDatabaseHas(self::PLAYERS_TABLE, $data);
    }

    /** @test */
    public function it_can_find_player_by_id()
    {
        $player = factory(Player::class)->create();
        factory(Player::class)->create();
        $_player = $this->playerRepository->findById($player->id);
        $this->assertInstanceOf(Player::class, $_player);
        $this->assertEquals($player->id, $_player->id);
    }

    /** @test */
    public function it_can_find_players()
    {
        $player = factory(Player::class)->create();
        $players = $this->playerRepository->get();
        $this->assertInstanceOf(Collection::class, $players);
        $this->assertCount(1, $players);
        $players->each(function ($_player) use ($player) {
            $this->assertInstanceOf(Player::class, $_player);
            $this->assertEquals($player->id, $_player->id);
        });
    }

    /** @test */
    public function it_can_paginate_players()
    {
        $player = factory(Player::class)->create();
        $players = $this->playerRepository->paginate();
        $this->assertInstanceOf(LengthAwarePaginator::class, $players);
        $this->assertCount(1, $players->items());
        collect($players->items())->each(function ($_player) use ($player) {
            $this->assertInstanceOf(Player::class, $_player);
            $this->assertEquals($player->id, $_player->id);
        });
    }

    /** @test */
    public function it_can_update_the_player()
    {
        $player = factory(Player::class)->create();
        $data = factory(Player::class)->make()->toArray();
        $this->playerRepository->setModel($player);
        $this->playerRepository->update($data);
        $this->assertDatabaseHas(self::PLAYERS_TABLE, array_merge($data, [
            'id' => $player->id
        ]));
    }

    /** @test */
    public function it_can_delete_the_player()
    {
        $player = factory(Player::class)->create();
        $_player = factory(Player::class)->create();
        $this->playerRepository->setModel($player);
        $this->playerRepository->delete();
        $this->assertDatabaseMissing(self::PLAYERS_TABLE, [
            'id' => $player->id
        ]);
        $this->assertDatabaseHas(self::PLAYERS_TABLE, [
            'id' => $_player->id
        ]);
    }
}
