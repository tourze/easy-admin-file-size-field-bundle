<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Twig;

use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * 字节格式化Twig扩展
 */
class BytesFormatterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_bytes', [$this, 'formatBytes']),
        ];
    }

    /**
     * 格式化字节显示
     */
    public function formatBytes(?int $bytes): string
    {
        if ($bytes === null || $bytes < 0) {
            return '0 B';
        }
        return FileSizeField::getFormatValue($bytes);
    }
}
