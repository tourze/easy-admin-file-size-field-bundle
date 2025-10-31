<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Twig;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EasyAdminFileSizeFieldBundle\Twig\BytesFormatterExtension;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;

/**
 * @internal
 */
#[CoversClass(BytesFormatterExtension::class)]
#[RunTestsInSeparateProcesses]
final class BytesFormatterExtensionTest extends AbstractIntegrationTestCase
{
    private BytesFormatterExtension $extension;

    protected function onSetUp(): void
    {
        $this->extension = self::getService(BytesFormatterExtension::class);
    }

    public function testExtensionExists(): void
    {
        $this->assertInstanceOf(BytesFormatterExtension::class, $this->extension);
    }

    #[DataProvider('provideBytesData')]
    public function testFormatBytes(?int $bytes, string $expected): void
    {
        $result = $this->extension->formatBytes($bytes);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array<string, array{0: int|null, 1: string}>
     */
    public static function provideBytesData(): array
    {
        return [
            'null bytes' => [null, '0 B'],
            'negative bytes' => [-100, '0 B'],
            'zero bytes' => [0, '0 B'],
            'one byte' => [1, '1 B'],
            'kilobyte' => [1024, '1 KB'],
            'megabyte' => [1048576, '1 MB'],
            'gigabyte' => [1073741824, '1 GB'],
            'terabyte' => [1099511627776, '1 TB'],
            'petabyte' => [1125899906842624, '1 PB'],
            'random number' => [12345, '12.06 KB'],
        ];
    }
}
