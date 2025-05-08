<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EasyAdminFileSizeFieldBundleIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    protected function setUp(): void
    {
        static::bootKernel(['debug' => false]);
    }

    public function testBundleInitialization(): void
    {
        $kernel = self::$kernel;
        $this->assertNotNull($kernel);

        // 测试Bundle是否正确注册
        $bundles = $kernel->getBundles();
        $this->assertArrayHasKey('EasyAdminFileSizeFieldBundle', $bundles);
    }
}
