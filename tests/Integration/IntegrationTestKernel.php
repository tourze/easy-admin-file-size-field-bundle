<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Tourze\EasyAdminFileSizeFieldBundle\EasyAdminFileSizeFieldBundle;

class IntegrationTestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new EasyAdminFileSizeFieldBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', [
                'test' => true,
                'secret' => 'test',
            ]);
        });
    }
}
