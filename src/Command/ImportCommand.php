<?php

namespace Apperclass\Bundle\FixtureBundle\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Apperclass\Bundle\FixtureBundle\Entity\EntityManager;
use Apperclass\Bundle\FixtureBundle\Fixture\Manager\FixtureManager;
use Apperclass\Bundle\FixtureBundle\Process\ImportFixtureProcess;

class ImportCommand extends ContainerAwareCommand

{
    protected function configure()
    {
        $this
            ->setName('apperclass:fixture:import')
            ->setDescription('Import fixture to database')
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Format for import', 'yaml')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format = $input->getOption('format');
        // @TODO change manager for different formats
        $classNames = $this->getContainer()->getParameter('apperclass_fixture.classes');
        /** @var ImportFixtureProcess $importProcess */
        $importProcess = $this->getContainer()->get('apperclass_fixture.importProcess');
        $importProcess->setOutput($output);
        $importProcess->execute($classNames);
    }
}