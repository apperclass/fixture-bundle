<?php

namespace Apperclass\Bundle\FixtureBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Apperclass\Bundle\FixtureBundle\Entity\EntityCollectionInterface;

/**
 * Class EncodedDataEvent
 *
 * @package Apperclass\Bundle\FixtureBundle\Event
 */
class EntityCollectionEvent extends Event
{
    /** @var EntityCollectionInterface */
    protected $entityCollection;

    /**
     * @param \Apperclass\Bundle\FixtureBundle\Entity\EntityCollectionInterface $entityCollection
     */
    public function setEntityCollection($entityCollection)
    {
        $this->entityCollection = $entityCollection;
    }

    /**
     * @return \Apperclass\Bundle\FixtureBundle\Entity\EntityCollectionInterface
     */
    public function getEntityCollection()
    {
        return $this->entityCollection;
    }



}