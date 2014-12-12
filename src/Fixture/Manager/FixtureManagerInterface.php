<?php

namespace Apperclass\Bundle\FixtureBundle\Fixture\Manager;

interface FixtureManagerInterface
{
    public function import($className);
    public function export($className);
}