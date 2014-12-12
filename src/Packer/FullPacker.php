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

class FullPacker extends Packer
{

    /**
     * __construct
     */
    public function __construct(PropertyAnalyzer $propertyAnalyzer, AssociationAnalyzer $associationAnalyzer)
    {
        $this->analyzers = array($propertyAnalyzer, $associationAnalyzer);
    }

}