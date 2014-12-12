<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;

interface PropertyAnalyzerInterface
{
    public function fromEntity(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity);

    public function fromFixture(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity);
}