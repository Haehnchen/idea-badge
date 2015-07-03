<?php

namespace espend\IdeaBadgeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class PoserProviderPass implements CompilerPassInterface
{

    private $interface = 'espend\IdeaBadge\Poser\PoserGeneratorInterface';

    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('espend_idea_badge.generator_manager')) {
            return;
        }

        $providerNames = array();

        $configuratorDef = $container->findDefinition('espend_idea_badge.generator_manager');
        foreach ($container->findTaggedServiceIds('espend_idea_badge.poser') as $id => $tags) {
            $configuratorDef->addMethodCall('addGenerator', array(new Reference($id)));

            $class = $container->getParameterBag()->resolveValue($container->getDefinition($id)->getClass());

            // call static method to get the provider name for more lazy loading of service tree
            $refClass = new \ReflectionClass($class);
            if (!$refClass->implementsInterface($this->interface)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $this->interface));
            }

            if (!($name = $class::getName()) || strlen($name) == 0 || !preg_match('#^[\w-]+$#', $name)) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must have a valid name', $id));
            }

            $providerNames[] = $name;
        }

        // collect provider names eg. for routing loader
        $container->setParameter('espend_idea_badge.poser_provider_names', $providerNames);
    }
}
