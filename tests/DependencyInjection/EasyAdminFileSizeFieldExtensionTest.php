<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection\EasyAdminFileSizeFieldExtension;

class EasyAdminFileSizeFieldExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $container = new ContainerBuilder();
        $extension = new EasyAdminFileSizeFieldExtension();

        // 确认没有异常抛出
        $extension->load([], $container);

        // 简单测试配置加载是否成功
        $this->assertTrue(true);
    }
}
