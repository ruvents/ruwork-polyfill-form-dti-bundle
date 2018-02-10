<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests;

use PHPUnit\Framework\TestCase;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\Compiler\RemoveDoctrineOrmDTIGuesserPass;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\RuworkPolyfillFormDTIExtension;
use Ruwork\PolyfillFormDTIBundle\RuworkPolyfillFormDTIBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RuworkPolyfillFormDTIBundleTest extends TestCase
{
    public function testExtension()
    {
        $bundle = new RuworkPolyfillFormDTIBundle();
        $extension = $bundle->getContainerExtension();

        $this->assertNotNull($extension);
        $this->assertInstanceOf(RuworkPolyfillFormDTIExtension::class, $extension);
    }

    public function testBuild()
    {
        $bundle = new RuworkPolyfillFormDTIBundle();
        $container = new ContainerBuilder();

        $bundle->build($container);

        $passesCount = 0;

        foreach ($container->getCompiler()->getPassConfig()->getPasses() as $pass) {
            if ($pass instanceof RemoveDoctrineOrmDTIGuesserPass) {
                ++$passesCount;
            }
        }

        $this->assertSame(
            1,
            $passesCount,
            sprintf('Bundle does not register the %s.', RemoveDoctrineOrmDTIGuesserPass::class)
        );
    }
}
