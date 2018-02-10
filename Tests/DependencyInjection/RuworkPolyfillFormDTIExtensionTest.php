<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Ruwork\PolyfillFormDTI\Extension\DateTimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\DateTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\TimeTypeDTIExtension;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\RuworkPolyfillFormDTIExtension;
use Symfony\Component\Form\DependencyInjection\FormPass;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class RuworkPolyfillFormDTIExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @dataProvider generateTestData
     */
    public function test($id, $class, $extendedType)
    {
        $this->load([]);
        $this->container->compile();

        $this->assertContainerBuilderHasService($id, $class);

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            $id,
            'form.type_extension',
            ['extended_type' => $extendedType, 'priority' => 1024]
        );

        $this->assertSame(!class_exists(FormPass::class), $this->container->findDefinition($id)->isPublic());
    }

    public function generateTestData()
    {
        yield [
            'ruwork_polyfill_form_dti.extension.date_time',
            DateTimeTypeDTIExtension::class,
            DateTimeType::class,
        ];

        yield [
            'ruwork_polyfill_form_dti.extension.date',
            DateTypeDTIExtension::class,
            DateType::class,
        ];

        yield [
            'ruwork_polyfill_form_dti.extension.time',
            TimeTypeDTIExtension::class,
            TimeType::class,
        ];
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
