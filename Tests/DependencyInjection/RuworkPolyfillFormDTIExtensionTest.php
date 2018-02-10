<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Ruwork\PolyfillFormDTI\Extension\DateTimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\DateTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\TimeTypeDTIExtension;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\RuworkPolyfillFormDTIExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class RuworkPolyfillFormDTIExtensionTest extends AbstractExtensionTestCase
{
    public function test()
    {
        $this->load([]);
        $this->container->compile();

        $this->assertContainerBuilderHasService(
            'ruwork_polyfill_form_dti.extension.date_time',
            DateTimeTypeDTIExtension::class
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'ruwork_polyfill_form_dti.extension.date_time',
            'form.type_extension',
            ['extended_type' => DateTimeType::class]
        );

        $this->assertContainerBuilderHasService(
            'ruwork_polyfill_form_dti.extension.date',
            DateTypeDTIExtension::class
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'ruwork_polyfill_form_dti.extension.date',
            'form.type_extension',
            ['extended_type' => DateType::class]
        );

        $this->assertContainerBuilderHasService(
            'ruwork_polyfill_form_dti.extension.time',
            TimeTypeDTIExtension::class
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'ruwork_polyfill_form_dti.extension.time',
            'form.type_extension',
            ['extended_type' => TimeType::class]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new RuworkPolyfillFormDTIExtension(),
        ];
    }
}
