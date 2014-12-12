<?php

namespace Apperclass\Bundle\FixtureBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;

/**
 * Class EncodedDataEvent
 *
 * @package Apperclass\Bundle\FixtureBundle\Event
 */
class FixturePackEvent extends Event
{
    /** @var FixturePackInterface */
    protected $fixturePackEvent;

    /**
     * @param \Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface $fixturePackEvent
     */
    public function setFixturePackEvent($fixturePackEvent)
    {
        $this->fixturePackEvent = $fixturePackEvent;
    }

    /**
     * @return \Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface
     */
    public function getFixturePackEvent()
    {
        return $this->fixturePackEvent;
    }



}