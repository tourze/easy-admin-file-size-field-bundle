<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Field;

use ChrisUllyott\FileSize;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

final class FileSizeField implements FieldInterface
{
    use FieldTrait;

    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('@EasyAdminFileSizeField/file_size.html.twig')
            ->setFormType(FileSizeType::class)
            ->addCssClass('field-file-size')
            ->addCssFiles(Asset::new('bundles/easyadminfilesizefield/file-size-field.css'))
            ->formatValue(FileSizeField::getFormatValue(...));
    }

    /**
     * 格式化字节大小为可读形式
     */
    public static function getFormatValue(int $bytes): string
    {
        try {
            return (new FileSize($bytes))->asAuto();
        } catch (\Exception $e) {
        }
        return $bytes . ' B';
    }
}
