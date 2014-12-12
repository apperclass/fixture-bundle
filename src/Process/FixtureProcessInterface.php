<?php

namespace Apperclass\Bundle\FixtureBundle\Process;

use Apperclass\Bundle\FixtureBundle\Fixture\Manager\FixtureManagerInterface;

/**
 * Interface FixtureProcessInterface
 *
 * @package Apperclass\Bundle\FixtureBundle\Process
 */
interface FixtureProcessInterface
{
    /**
     * @param array $classNames
     *
     * @return mixed
     */
    public function execute($classNames);

    /**
     * @param FixtureManagerInterface $fixtureManager
     *
     * @return mixed
     */
    public function addFixtureManager(FixtureManagerInterface $fixtureManager);
}