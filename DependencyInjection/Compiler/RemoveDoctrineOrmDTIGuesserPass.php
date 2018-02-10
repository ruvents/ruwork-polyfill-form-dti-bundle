<?php

namespace Ruwork\PolyfillFormDTIBundle\DependencyInjection\Compiler;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RemoveDoctrineOrmDTIGuesserPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $id = 'ruwork_polyfill_form_dti.guesser.doctrine_orm';

        if (!$container->has($id)) {
            return;
        }

        if (!defined(Type::class.'::DATETIME_IMMUTABLE')) {
            $container->removeDefinition($id);
        }

        if (!$container->has('doctrine')) {
            $container->removeDefinition($id);
        }
    }
}
