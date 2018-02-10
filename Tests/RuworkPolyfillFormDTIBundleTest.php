<?php

namespace Ruwork\PolyfillFormDTIBundle\Tests;

use PHPUnit\Framework\TestCase;
use Ruwork\PolyfillFormDTIBundle\DependencyInjection\RuworkPolyfillFormDTIExtension;
use Ruwork\PolyfillFormDTIBundle\RuworkPolyfillFormDTIBundle;

class RuworkPolyfillFormDTIBundleTest extends TestCase
{
    public function testExtensionClass()
    {
        $bundle = new RuworkPolyfillFormDTIBundle();

        $this->assertInstanceOf(RuworkPolyfillFormDTIExtension::class, $bundle->getContainerExtension());
    }
}
