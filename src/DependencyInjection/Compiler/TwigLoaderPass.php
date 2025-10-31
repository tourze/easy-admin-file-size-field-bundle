<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigLoaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('twig.loader.filesystem')) {
            return;
        }

        $twigLoaderDefinition = $container->getDefinition('twig.loader.filesystem');
        $twigLoaderDefinition->addMethodCall('addPath', [
            __DIR__ . '/../../Resources/views',
            'EasyAdminFileSizeField',
        ]);
    }
}
