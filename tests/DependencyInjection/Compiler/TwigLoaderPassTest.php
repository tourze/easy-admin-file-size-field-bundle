<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection\Compiler\TwigLoaderPass;

/**
 * @internal
 */
#[CoversClass(TwigLoaderPass::class)]
final class TwigLoaderPassTest extends TestCase
{
    public function testProcessWithoutTwigLoader(): void
    {
        $container = new ContainerBuilder();
        $pass = new TwigLoaderPass();

        $pass->process($container);

        self::assertFalse($container->hasDefinition('twig.loader.filesystem'));
    }

    public function testProcessWithTwigLoader(): void
    {
        $container = new ContainerBuilder();
        $twigLoaderDefinition = new Definition();
        $container->setDefinition('twig.loader.filesystem', $twigLoaderDefinition);

        $pass = new TwigLoaderPass();
        $pass->process($container);

        self::assertTrue($container->hasDefinition('twig.loader.filesystem'));

        $methodCalls = $twigLoaderDefinition->getMethodCalls();
        self::assertCount(1, $methodCalls);

        $methodCall = $methodCalls[0];
        self::assertSame('addPath', $methodCall[0]);
        self::assertCount(2, $methodCall[1]);
        self::assertStringEndsWith('/Resources/views', $methodCall[1][0]);
        self::assertSame('EasyAdminFileSizeField', $methodCall[1][1]);
    }
}
