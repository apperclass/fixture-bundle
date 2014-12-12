<?php

namespace Apperclass\Bundle\FixtureBundle\Fixture\Manager;

use Apperclass\Bundle\FixtureBundle\Entity\EntityManagerInterface;
use Apperclass\Bundle\FixtureBundle\Packer\PackerInterface;
use Apperclass\Bundle\FixtureBundle\Parser\DataManagerInterface;
use Apperclass\Bundle\FixtureBundle\Parser\ParserInterface;

class FixtureManager implements FixtureManagerInterface
{
    /** @var ParserInterface $parser */
    protected $parser;

    /** @var PackerInterface $packer */
    protected $packer;

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /** @var DataManagerInterface $dataManager */
    protected $dataManager;

    public function __construct(
        ParserInterface $parser,
        PackerInterface $packer,
        EntityManagerInterface $entityManager,
        DataManagerInterface $dataManager)
    {
        $this->parser = $parser;
        $this->packer = $packer;
        $this->entityManager = $entityManager;
        $this->dataManager = $dataManager;
    }

    /**
     * @param string $className
     */
    public function import($className)
    {
        $data = $this->dataManager->load($className);
        $fixturePack = $this->parser->decode($data);
        $entityCollection = $this->packer->unpack($fixturePack);
        $this->entityManager->save($entityCollection);
    }

    /**
     * save
     */
    public function export($className)
    {
        $entityCollection = $this->entityManager->load($className);
        $fixturePack = $this->packer->pack($entityCollection);
        $data = $this->parser->encode($fixturePack);
        $this->dataManager->save($data);
    }
}