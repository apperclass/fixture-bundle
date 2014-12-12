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

class PurgeCommand extends ContainerAwareCommand

{
    protected function configure()
    {
        $this
            ->setName('apperclass:fixture:purge')
            ->setDescription('Purge Database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $purger = $this->getContainer()->get('apperclass_fixture.purger');
        $purger->purge();
        $output->writeln('Purge success');
    }
}