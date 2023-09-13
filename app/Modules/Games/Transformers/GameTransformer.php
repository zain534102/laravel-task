<?php

namespace App\Modules\Games\Transformers;

use App\Modules\Games\Game;
use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param Game $game
     * @return array
     */
    public function transform(Game $game)
    {
        return $game->toArray();
    }
}
