<?php

namespace Ruwork\PolyfillFormDTIBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Form\DependencyInjection\FormPass;

final class RuworkPolyfillFormDTIExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $public = !class_exists(FormPass::class);

        $container->findDefinition('ruwork_polyfill_form_dti.extension.date_time')
            ->setPublic($public);

        $container->findDefinition('ruwork_polyfill_form_dti.extension.date')
            ->setPublic($public);

        $container->findDefinition('ruwork_polyfill_form_dti.extension.time')
            ->setPublic($public);

        $container->findDefinition('ruwork_polyfill_form_dti.guesser.doctrine_orm')
            ->setPublic($public);
    }
}
