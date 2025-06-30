<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection\EasyAdminFileSizeFieldExtension;
use Tourze\EasyAdminFileSizeFieldBundle\EasyAdminFileSizeFieldBundle;

class EasyAdminFileSizeFieldBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new EasyAdminFileSizeFieldBundle();
        $extension = $bundle->getContainerExtension();
        
        $this->assertInstanceOf(EasyAdminFileSizeFieldExtension::class, $extension);
    }
    
    public function testGetName(): void
    {
        $bundle = new EasyAdminFileSizeFieldBundle();
        
        $this->assertEquals('EasyAdminFileSizeFieldBundle', $bundle->getName());
    }
    
    public function testGetPath(): void
    {
        $bundle = new EasyAdminFileSizeFieldBundle();
        $path = $bundle->getPath();
        
        $this->assertStringContainsString('easy-admin-file-size-field-bundle', $path);
    }
}