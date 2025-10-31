<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection\EasyAdminFileSizeFieldExtension;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;

/**
 * @internal
 */
#[CoversClass(EasyAdminFileSizeFieldExtension::class)]
final class EasyAdminFileSizeFieldExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    protected function provideServiceDirectories(): iterable
    {
        yield from parent::provideServiceDirectories();
        yield 'Form';
        yield 'Field';
    }
}
