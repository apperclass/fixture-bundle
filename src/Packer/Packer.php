<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Doctrine\ORM\Mapping\Column;
use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Fixture\Fixture;
use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePack;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;
use Apperclass\Bundle\FixtureBundle\Key\Method;
use Apperclass\Bundle\FixtureBundle\Key\Property;
use Apperclass\Bundle\FixtureBundle\Util\Identificator;

class Packer implements PackerInterface
{
    protected $analyzers;

    /**
     * __construct
     */
    public function __construct(PropertyAnalyzer $propertyAnalyzer)
    {
        $this->analyzers = array($propertyAnalyzer);
    }

    /**
     * @param PropertyAnalyzerInterface $propertyAnalyzer
     */
    public function addAnalyzer(PropertyAnalyzerInterface $propertyAnalyzer)
    {
        $this->analyzers[] = $propertyAnalyzer;
    }

    /**
     * @param FixturePackInterface $fixturePack
     *
     * @return mixed $entity
     */
    public function unpack(FixturePackInterface $fixturePack)
    {
        $entityCollection = new EntityCollection();
        $className = $fixturePack->getClassName();
        $entityCollection->setClassName($className);

        foreach ($fixturePack->getFixtures() as $fixture) {
            $entity = new $className();
            $reflectionClass = new \ReflectionClass($entity);
            $reflectionProperties = $reflectionClass->getProperties();
            foreach ($reflectionProperties as $reflectionProperty) {
                $reflectionProperty->setAccessible(true);
                foreach ($this->analyzers as $analyzer) {
                    /** @var PropertyAnalyzerInterface $analyzer */
                    $analyzer->fromFixture($reflectionProperty, $fixture, $entity);
                }
            }

            $entityCollection->addEntity($entity);
        }

        return $entityCollection;
    }

    /**
     * @param EntityCollection $entityCollection
     *
     * @return FixturePackInterface
     */
    public function pack(EntityCollection $entityCollection)
    {
        $fixturePack = new FixturePack();
        $fixturePack->setClassName($entityCollection->getClassName());
        $identificator = new Identificator();
        foreach ($entityCollection->getEntities() as $entity) {
            $fixture = new Fixture();
            $fixture->setId($identificator->getFromEntity($entity));
            $reflectionClass = new \ReflectionClass($entity);
            $reflectionProperties = $reflectionClass->getProperties();
            foreach ($reflectionProperties as $reflectionProperty) {
                $reflectionProperty->setAccessible(true);
                foreach ($this->analyzers as $analyzer) {
                    /** @var PropertyAnalyzerInterface $analyzer */
                    $analyzer->fromEntity($reflectionProperty, $fixture, $entity);
                }
            }

            $fixturePack->addFixture($fixture);
        }
        return $fixturePack;
    }


}