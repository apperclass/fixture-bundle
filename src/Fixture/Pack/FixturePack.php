<?php

namespace Apperclass\Bundle\FixtureBundle\Fixture\Pack;

use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Entity\EntityCollectionInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Fixture;
use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;

class FixturePack implements FixturePackInterface
{
    protected $fixtures;
    protected $shortName;
    protected $className;

    public function __construct()
    {
        $this->fixtures = array();
    }

    /**
     * @param FixtureInterface $fixture
     */
    public function addFixture(FixtureInterface $fixture)
    {
        $this->fixtures[] = $fixture;
    }

    /**
     * @return FixtureInterface[]
     */
    public function getFixtures()
    {
        return $this->fixtures;
    }


    /**
     * @param string $className
     */
    public function setClassName($className)
    {

        $this->className = $className;
        $this->shortName = $this->generateShortName($className);
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param $className
     * @return mixed
     */
    protected function generateShortName($className)
    {
        return str_replace('\\', '_', strtolower($className));
    }
}