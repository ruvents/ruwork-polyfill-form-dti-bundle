<?php

namespace Ruwork\PolyfillFormDTIBundle;

use Ruwork\PolyfillFormDTIBundle\DependencyInjection\Compiler\RemoveDoctrineOrmDTIGuesserPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class RuworkPolyfillFormDTIBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RemoveDoctrineOrmDTIGuesserPass());
    }
}
