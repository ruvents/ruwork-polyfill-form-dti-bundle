<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\Compiler\RemoveDoctrineOrmDTIGuesserPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveDoctrineOrmDTIGuesserPassTest extends AbstractCompilerPassTestCase
{
    public function testGuesserIsRemovedIfNoConstant()
    {
        $this->registerService('doctrine', 'Class');

        $this->registerService('ruwork_polyfill_form_dti.guesser.doctrine_orm', 'Class');
        $this->compile();

        $this->assertContainerBuilderNotHasService('ruwork_polyfill_form_dti.guesser.doctrine_orm');
    }

    public function testGuesserIsRemovedIfNoDoctrineService()
    {
        require_once __DIR__.'/../../Fixtures/doctrine_type.php';

        $this->registerService('ruwork_polyfill_form_dti.guesser.doctrine_orm', 'Class');
        $this->compile();

        $this->assertContainerBuilderNotHasService('ruwork_polyfill_form_dti.guesser.doctrine_orm');
    }

    public function testGuesserIsNotRemoved()
    {
        require_once __DIR__.'/../../Fixtures/doctrine_type.php';
        $this->registerService('doctrine', 'Class');

        $this->registerService('ruwork_polyfill_form_dti.guesser.doctrine_orm', 'Class');
        $this->compile();

        $this->assertContainerBuilderHasService('ruwork_polyfill_form_dti.guesser.doctrine_orm');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RemoveDoctrineOrmDTIGuesserPass());
    }
}
