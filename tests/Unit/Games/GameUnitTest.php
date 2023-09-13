<?php

namespace Tests\Unit\Games;

use App\Modules\Games\Contracts\Repositories\GameRepository;
use App\Modules\Games\Game;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GameUnitTest extends TestCase
{
    const GAMES_TABLE = 'games';

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->gameRepository = $this->app->make(GameRepository::class);
    }

    /** @test */
    public function it_can_create_game()
    {
        $data = factory(Game::class)->make()->toArray();
        $game = $this->gameRepository->create($data);
        $this->assertInstanceOf(Game::class, $game);
        $this->assertDatabaseHas(self::GAMES_TABLE, $data);
    }

    /** @test */
    public function it_can_find_game_by_id()
    {
        $game = factory(Game::class)->create();
        factory(Game::class)->create();
        $_game = $this->gameRepository->findById($game->id);
        $this->assertInstanceOf(Game::class, $_game);
        $this->assertEquals($game->id, $_game->id);
    }

    /** @test */
    public function it_can_find_games()
    {
        $game = factory(Game::class)->create();
        $games = $this->gameRepository->get();
        $this->assertInstanceOf(Collection::class, $games);
        $this->assertCount(1, $games);
        $games->each(function ($_game) use ($game) {
            $this->assertInstanceOf(Game::class, $_game);
            $this->assertEquals($game->id, $_game->id);
        });
    }

    /** @test */
    public function it_can_paginate_games()
    {
        $game = factory(Game::class)->create();
        $games = $this->gameRepository->paginate();
        $this->assertInstanceOf(LengthAwarePaginator::class, $games);
        $this->assertCount(1, $games->items());
        collect($games->items())->each(function ($_game) use ($game) {
            $this->assertInstanceOf(Game::class, $_game);
            $this->assertEquals($game->id, $_game->id);
        });
    }

    /** @test */
    public function it_can_update_the_game()
    {
        $game = factory(Game::class)->create();
        $data = factory(Game::class)->make()->toArray();
        $this->gameRepository->setModel($game);
        $this->gameRepository->update($data);
        $this->assertDatabaseHas(self::GAMES_TABLE, array_merge($data, [
            'id' => $game->id
        ]));
    }

    /** @test */
    public function it_can_delete_the_game()
    {
        $game = factory(Game::class)->create();
        $_game = factory(Game::class)->create();
        $this->gameRepository->setModel($game);
        $this->gameRepository->delete();
        $this->assertDatabaseMissing(self::GAMES_TABLE, [
            'id' => $game->id
        ]);
        $this->assertDatabaseHas(self::GAMES_TABLE, [
            'id' => $_game->id
        ]);
    }
}
