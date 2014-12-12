<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;

/**
 * Interface PropertyAnalyzerInterface
 *
 * @package Apperclass\Bundle\FixtureBundle\Packer
 */
interface PropertyAnalyzerInterface
{
    /**
     * @param \ReflectionProperty $reflectionProperty
     * @param FixtureInterface    $fixture
     * @param mixed               $entity
     */
    public function fromEntity(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity);

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @param FixtureInterface    $fixture
     * @param mixed               $entity
     */
    public function fromFixture(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity);
}