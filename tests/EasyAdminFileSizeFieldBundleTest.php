<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EasyAdminFileSizeFieldBundle\EasyAdminFileSizeFieldBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(EasyAdminFileSizeFieldBundle::class)]
#[RunTestsInSeparateProcesses]
final class EasyAdminFileSizeFieldBundleTest extends AbstractBundleTestCase
{
}
