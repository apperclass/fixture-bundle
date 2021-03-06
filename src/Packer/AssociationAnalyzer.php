<?php

namespace Apperclass\Bundle\FixtureBundle\Packer;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Apperclass\Bundle\FixtureBundle\Entity\EntityCollection;
use Apperclass\Bundle\FixtureBundle\Fixture\FixtureInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Pack\FixturePackInterface;
use Apperclass\Bundle\FixtureBundle\Key\Method;
use Apperclass\Bundle\FixtureBundle\Util\Identificator;

/**
 * Class AssociationAnalyzer
 *
 * @package Apperclass\Bundle\FixtureBundle\Packer
 */
class AssociationAnalyzer implements PropertyAnalyzerInterface
{

    protected $entityManager;
    protected $metadataFactory;
    protected $identificator;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->metadataFactory = $this->entityManager->getMetadataFactory();
        $this->identificator = new Identificator();
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @param FixtureInterface    $fixture
     * @param mixed               $entity
     */
    public function fromEntity(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity)
    {
        $name = $reflectionProperty->getName();
        $value = $reflectionProperty->getValue($entity);
        $classMetadata = $this->metadataFactory->getMetadataFor(get_class($entity));
        if (!$classMetadata->hasAssociation($name)) {
            return;
        }

        if ($classMetadata->isCollectionValuedAssociation($name)) {
            $this->setFixtureAssociations($fixture, $name, $value);
        } else if ($classMetadata->isSingleValuedAssociation($name)) {
            $this->setFixtureAssociation($fixture, $name, $value);
        }
    }

    /**
     * @param \ReflectionProperty $reflectionProperty
     * @param FixtureInterface    $fixture
     * @param mixed               $entity
     */
    public function fromFixture(\ReflectionProperty $reflectionProperty, FixtureInterface $fixture, $entity)
    {
        $name = $reflectionProperty->getName();
        $value = $fixture->getProperty($name);
        $classMetadata = $this->metadataFactory->getMetadataFor(get_class($entity));
        if (!$classMetadata->hasAssociation($name)) {
            return;
        }
        if (is_null($value)) {
            return;
        }

        if ($classMetadata->isCollectionValuedAssociation($name)) {
            $this->setEntityAssociations($entity, $reflectionProperty, $value, $classMetadata->getAssociationTargetClass($name));
        } else if ($classMetadata->isSingleValuedAssociation($name)) {
            $this->setEntityAssociation($entity, $reflectionProperty, $value, $classMetadata->getAssociationTargetClass($name));
        }

    }

    /**
     * @param mixed               $entity
     * @param \ReflectionProperty $reflectionProperty
     * @param integer             $id
     * @param string              $targetEntityClass
     */
    public function setEntityAssociation($entity, $reflectionProperty, $id, $targetEntityClass)
    {
        try {
            $repository = $this->entityManager->getRepository($targetEntityClass);
            $idPropertyName = $this->identificator->getIdPropertyName($targetEntityClass);
            $object = $repository->findOneBy(array($idPropertyName=>$id));
            $reflectionProperty->setValue($entity, $object);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @param mixed               $entity
     * @param \ReflectionProperty $reflectionProperty
     * @param array               $ids
     * @param string              $targetEntityClass
     */
    public function setEntityAssociations($entity, $reflectionProperty, $ids, $targetEntityClass)
    {
        try {
            $repository = $this->entityManager->getRepository($targetEntityClass);
            $idPropertyName = $this->identificator->getIdPropertyName($targetEntityClass);
            $collection = array();
            foreach ($ids as $id) {
                $object = $repository->findOneBy(array($idPropertyName=>$id));
                if ($object) {
                    $collection[] = $object;
                } else {
                    throw new \Exception('Set Entity Associations object not found ' . $targetEntityClass . ' ' . $id);
                }
            }
            $reflectionProperty->setValue($entity, $collection);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    /**
     * @param FixtureInterface $fixture
     * @param string           $name
     * @param mixed            $value
     */
    public function setFixtureAssociations(FixtureInterface $fixture, $name, $value)
    {
        $ids = array();
        foreach ($value as $object) {
            $ids[] = $this->identificator->getFromEntity($object);
        }
        $fixture->setProperty($name, $ids);
    }

    /**
     * @param FixtureInterface $fixture
     * @param string           $name
     * @param string           $value
     */
    public function setFixtureAssociation(FixtureInterface $fixture, $name, $value)
    {
        if (!$value) {
            return;
        }
        $fixture->setProperty($name, $this->identificator->getFromEntity($value));
    }

}
