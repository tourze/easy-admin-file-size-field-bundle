<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Twig;

use PHPUnit\Framework\TestCase;
use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;

class BytesFormatterExtensionTest extends TestCase
{
    private BytesFormatterExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new BytesFormatterExtension();
    }

    public function testGetFilters(): void
    {
        $filters = $this->extension->getFilters();
        
        $this->assertCount(1, $filters);
        $this->assertInstanceOf(\Twig\TwigFilter::class, $filters[0]);
        $this->assertEquals('format_bytes', $filters[0]->getName());
    }

    /**
     * @dataProvider provideBytesData
     */
    public function testFormatBytes(?int $bytes, string $expected): void
    {
        $result = $this->extension->formatBytes($bytes);
        $this->assertEquals($expected, $result);
    }

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