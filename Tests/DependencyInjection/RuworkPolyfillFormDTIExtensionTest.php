<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Ruwork\PolyfillFormDTI\Extension\DateTimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\DateTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Extension\TimeTypeDTIExtension;
use Ruwork\PolyfillFormDTI\Guesser\DoctrineOrmDTIGuesser;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\RuworkPolyfillFormDTIExtension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Form\DependencyInjection\FormPass;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class RuworkPolyfillFormDTIExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @dataProvider generateTestData
     */
    public function testExtensionServices($id, $class, $extendedType)
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

    public function testGuesser()
    {
        $this->load([]);
        $this->container->compile();

        $this->assertContainerBuilderHasService(
            'ruwork_polyfill_form_dti.guesser.doctrine_orm',
            DoctrineOrmDTIGuesser::class
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'ruwork_polyfill_form_dti.guesser.doctrine_orm',
            0,
            new Reference('doctrine')
        );

        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'ruwork_polyfill_form_dti.guesser.doctrine_orm',
            'form.type_guesser'
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
