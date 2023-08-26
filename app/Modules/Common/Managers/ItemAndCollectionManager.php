<?php

namespace App\Modules\Common\Managers;

use App\Modules\Common\Serializers\JSendSerializer;
use League\Fractal\Manager;
use League\Fractal\Scope;

class ItemAndCollectionManager
{
    /**
     * @var Manager
     */
    private Manager $manager;

    /**
     * ItemManager constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $object
     * @param array $includes
     * @return Scope
     */
    public function createData($object, array $includes = []) : Scope
    {
        $this->manager->parseIncludes($includes);
        $this->manager->setSerializer(new JSendSerializer());
        return $this->manager->createData($object);
    }
}
