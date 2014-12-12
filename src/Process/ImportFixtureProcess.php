<?php

namespace Apperclass\Bundle\FixtureBundle\Process;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Manager\FixtureManagerInterface;
use Apperclass\Bundle\FixtureBundle\Purge\Purger;

/**
 * Class ImportFixtureProcess
 *
 * @package Apperclass\Bundle\FixtureBundle\Process
 */
class ImportFixtureProcess implements FixtureProcessInterface
{
    /** @var FixtureManagerInterface[] */
    protected $fixtureManagers;
    /** @var FixtureManagerInterface */
    protected $associationManager;
    /** @var OutputInterface */
    protected $output;
    /** @var Purger $purger */
    protected $purger;

    /**
     * @param Purger                    $purger
     */
    public function __construct(Purger $purger)
    {
        $this->fixtureManagers = array();
        $this->purger = $purger;
    }

    /**
     * @param FixtureManagerInterface $fixtureManager
     *
     * @return mixed|void
     */
    public function addFixtureManager(FixtureManagerInterface $fixtureManager)
    {
        $this->fixtureManagers[] = $fixtureManager;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @param array $classNames
     *
     * @return mixed
     */
    public function execute($classNames)
    {
        $this->purger->purge();
        try {
            foreach ($this->fixtureManagers as $fixtureManager) {
                foreach ($classNames as $className) {
                    $fixtureManager->import($className);
                    $this->output->writeln('[IMPORT] ' .$className);
                }
            }
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
        }
    }
}