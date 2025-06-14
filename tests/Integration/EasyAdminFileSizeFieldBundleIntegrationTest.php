<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tourze\EasyAdminFileSizeFieldBundle\EasyAdminFileSizeFieldBundle;
use Tourze\IntegrationTestKernel\IntegrationTestKernel;

class EasyAdminFileSizeFieldBundleIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    protected static function createKernel(array $options = []): IntegrationTestKernel
    {
        $appendBundles = [
            FrameworkBundle::class => ['all' => true],
            EasyAdminFileSizeFieldBundle::class => ['all' => true],
        ];
        
        $entityMappings = [];

        return new IntegrationTestKernel(
            $options['environment'] ?? 'test',
            $options['debug'] ?? true,
            $appendBundles,
            $entityMappings
        );
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
