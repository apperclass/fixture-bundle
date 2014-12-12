<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Column;
use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Fixture\Fixture;
use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePack;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;
use Apperclass\Bundle\FixtureBundle\Key\Method;
use Apperclass\Bundle\FixtureBundle\Key\Property;
use Apperclass\Bundle\FixtureBundle\Util\Identificator;

class AssociationPacker extends Packer
{
    protected $entityManager;
    protected $identificator;

    /**
     * __construct
     */
    public function __construct(AssociationAnalyzer $associationAnalyzer, EntityManager $entityManager)
    {
        $this->analyzers = array($associationAnalyzer);
        $this->entityManager = $entityManager;
        $this->identificator = new Identificator();
    }


    /**
     * @param FixturePackInterface $fixturePack
     *
     * @throws \Exception
     * @return mixed $entity
     */
    public function unpack(FixturePackInterface $fixturePack)
    {
       $entityCollection = new EntityCollection();
        $className = $fixturePack->getClassName();
        $entityCollection->setClassName($className);
        $idPropertyName = $this->identificator->getIdPropertyName($className);
        $repository = $this->entityManager->getRepository($className);
        foreach ($fixturePack->getFixtures() as $fixture) {
            $entity = $repository->findOneBy(array($idPropertyName=>$fixture->getId()));
            if (!$entity) {
                throw new \Exception('Entity not found with id ' . $fixture->getProperty('id'));
            }
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

}
