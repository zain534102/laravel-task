<?php

namespace App\Modules\Players\Repositories;

use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Players\Contracts\Repositories\PlayerRepository as PlayerRepositoryContract;
use App\Modules\Players\Player;
use App\Modules\Players\Transformers\PlayerTransformer;
use League\Fractal\TransformerAbstract;

class PlayerRepository extends BaseRepository implements PlayerRepositoryContract
{
    /**
     * PlayerRepository constructor.
     *
     * @param Player $model
     */
    public function __construct(Player $model)
    {
        parent::__construct($model);
    }

    /**
     * @return TransformerAbstract
     */
    public function getTransformer(): TransformerAbstract
    {
        return new PlayerTransformer;
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'players';
    }
}

