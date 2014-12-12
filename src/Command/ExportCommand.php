<?php

namespace Apperclass\Bundle\FixtureBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Apperclass\Bundle\FixtureBundle\Fixture\Manager\FixtureManager;
use Apperclass\Bundle\FixtureBundle\Process\ExportFixtureProcess;
use Apperclass\Bundle\FixtureBundle\Process\FixtureProcessInterface;

class ExportCommand extends ContainerAwareCommand

{
    protected function configure()
    {
        $this
            ->setName('apperclass:fixture:export')
            ->setDescription('Export database to fixtures')
            ->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Format for export', 'yaml')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format = $input->getOption('format');
        // @TODO change manager for different formats
        /** @var ExportFixtureProcess $exportProcess */
        $exportProcess = $this->getContainer()->get('apperclass_fixture.export_process');
        $classNames = $this->getContainer()->getParameter('apperclass_fixture.classes');
        $exportProcess->setOutput($output);
        $exportProcess->execute($classNames);
    }
}