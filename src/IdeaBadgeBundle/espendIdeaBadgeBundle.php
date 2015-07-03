<?php

namespace espend\IdeaBadgeBundle;

use espend\IdeaBadgeBundle\DependencyInjection\Compiler\PoserProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class espendIdeaBadgeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new PoserProviderPass());
    }
}
