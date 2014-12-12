<?php

namespace Apperclass\Bundle\FixtureBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FixtureManagerCompilerPass
 *
 * @package Apperclass\Bundle\FixtureBundle\DependencyInjection
 */
class FixtureManagerCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->addManagers($container, 'apperclass_fixture.import_process', 'apperclass_fixture.import_fixture_manager');
        $this->addManagers($container, 'apperclass_fixture.export_process', 'apperclass_fixture.export_fixture_manager');
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $processName
     * @param string           $tagName
     */
    public function addManagers(ContainerBuilder $container, $processName, $tagName)
    {
        if (!$container->hasDefinition($processName)) {
            return;
        }
        $definition = $container->getDefinition($processName);
        $taggedServices = $container->findTaggedServiceIds($tagName);
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addFixtureManager',
                array(new Reference($id))
            );
        }
    }
}