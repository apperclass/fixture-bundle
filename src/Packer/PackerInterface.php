<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;

interface PackerInterface
{
    /**
     * @param EntityCollection $entityCollection
     *
     * @return FixturePackInterface
     */
    public function pack(EntityCollection $entityCollection);

    /**
     * @param FixturePackInterface $fixturePack
     *
     * @return mixed $entity
     */
    public function unpack(FixturePackInterface $fixturePack);
}