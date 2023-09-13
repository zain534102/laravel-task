<?php

namespace App\Modules\Players\Transformers;

use App\Modules\Players\Player;
use League\Fractal\TransformerAbstract;

class PlayerTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param Player $player
     * @return array
     */
    public function transform(Player $player)
    {
        return $player->toArray();
    }
}
