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

        if (class_exists(FormPass::class)) {
            foreach (['date_time', 'date', 'time'] as $type) {
                $container->findDefinition('ruwork_polyfill_form_dti.extension.'.$type)
                    ->setPublic(false);
            }
        }
    }
}
