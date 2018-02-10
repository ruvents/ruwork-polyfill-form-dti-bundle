<?php

namespace Ruwork\PolyfillFormDTIBundle\DependencyInjection;

use Ruwork\PolyfillFormDTI\Extension\DateTimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\DateTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\TimeTypeDTIExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Form\DependencyInjection\FormPass;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

final class RuworkImtblDateFormsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $public = !class_exists(FormPass::class);

        $container->register('ruwork_polyfill_form_dti.extension.date_time')
            ->setClass(DateTimeTypeDTIExtension::class)
            ->setPublic($public)
            ->addTag('form.type_extension', ['extended_type' => DateTimeType::class]);

        $container->register('ruwork_polyfill_form_dti.extension.date')
            ->setClass(DateTypeDTIExtension::class)
            ->setPublic($public)
            ->addTag('form.type_extension', ['extended_type' => DateType::class]);

        $container->register('ruwork_polyfill_form_dti.extension.time')
            ->setClass(TimeTypeDTIExtension::class)
            ->setPublic($public)
            ->addTag('form.type_extension', ['extended_type' => TimeType::class]);
    }
}
