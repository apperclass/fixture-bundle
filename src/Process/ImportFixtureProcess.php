<?php

namespace Apperclass\Bundle\FixtureBundle\Process;

use Apperclass\Bundle\FixtureBundle\Fixture\Manager\FixtureManagerInterface;
use Apperclass\Bundle\FixtureBundle\Purge\Purger;

class ImportFixtureProcess implements FixtureProcessInterface
{
    /** @var FixtureManagerInterface */
    protected $fixtureManager;
    /** @var FixtureManagerInterface */
    protected $associationManager;
    protected $output;
    protected $purger;

    public function __construct(
        FixtureManagerInterface $fixtureManager,
        FixtureManagerInterface $associationManager,
        Purger $purger)
    {
        $this->fixtureManager = $fixtureManager;
        $this->associationManager = $associationManager;
        $this->purger = $purger;
    }

    /**
     *
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @param array $classNames
     * @return mixed
     */
    public function execute($classNames)
    {

        $this->purger->purge();

        try {
            foreach ($classNames as $className) {
                $this->fixtureManager->import($className);
                $this->output->writeln('[IMPORT] ' .$className);
            }
            foreach ($classNames as $className) {
                $this->associationManager->import($className);
                $this->output->writeln('[ASSOCIATE] ' .$className);
            }

        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
        }
    }
}