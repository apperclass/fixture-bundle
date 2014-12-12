<?php

namespace Apperclass\Bundle\FixtureBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Apperclass\Bundle\FixtureBundle\DependencyInjection\FixtureManagerCompilerPass;

/**
 * Class ApperclassFixtureBundle
 *
 * @package Apperclass\Bundle\FixtureBundle
 */
class ApperclassFixtureBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FixtureManagerCompilerPass());
    }
}
