<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Twig;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;
use Twig\Attribute\AsTwigFilter;

/**
 * 字节格式化Twig扩展
 */
#[Autoconfigure(public: true)]
class BytesFormatterExtension
{
    /**
     * 格式化字节显示
     */
    #[AsTwigFilter(name: 'format_bytes')]
    public function formatBytes(?int $bytes): string
    {
        if (null === $bytes || $bytes < 0) {
            return '0 B';
        }

        return FileSizeField::getFormatValue($bytes);
    }
}
