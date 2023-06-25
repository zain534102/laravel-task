<?php

namespace App\Modules\Common\Managers;

use League\Fractal\Manager;
use League\Fractal\Scope;
use App\Modules\Common\Serializers\JSendSerializer;

class ItemAndCollectionManager
{

    /**
     * ItemManager constructor.
     * @param Manager $manager
     */
    public function __construct(public Manager $manager)
    {
    }

    /**
     * @param $object
     * @return Scope
     */
    public function createData($object,) : Scope
    {
        $this->manager->setSerializer(new JSendSerializer());
        return $this->manager->createData($object);
    }
}
