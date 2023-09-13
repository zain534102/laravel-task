<?php

namespace App\Modules\Games\Repositories;

use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Games\Contracts\Repositories\GameRepository as GameRepositoryContract;
use App\Modules\Games\Game;
use App\Modules\Games\Transformers\GameTransformer;
use League\Fractal\TransformerAbstract;

class GameRepository extends BaseRepository implements GameRepositoryContract
{
    /**
     * GameRepository constructor.
     *
     * @param Game $model
     */
    public function __construct(Game $model)
    {
        parent::__construct($model);
    }

    /**
     * @return TransformerAbstract
     */
    public function getTransformer(): TransformerAbstract
    {
        return new GameTransformer;
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'games';
    }
}

