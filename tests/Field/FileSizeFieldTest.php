<?php

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Field;

use PHPUnit\Framework\TestCase;
use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

class FileSizeFieldTest extends TestCase
{
    public function testNew_withValidPropertyName(): void
    {
        $field = FileSizeField::new('fileSize');

        $this->assertInstanceOf(FileSizeField::class, $field);
        $this->assertSame('fileSize', $field->getAsDto()->getProperty());
        $this->assertSame(FileSizeType::class, $field->getAsDto()->getFormType());
        $this->assertSame('@EasyAdminFileSizeField/file_size.html.twig', $field->getAsDto()->getTemplatePath());
        $this->assertStringContainsString('field-file-size', $field->getAsDto()->getCssClass());
    }

    public function testNew_withNullLabel(): void
    {
        $field = FileSizeField::new('fileSize', null);

        $this->assertNull($field->getAsDto()->getLabel());
    }

    public function testNew_withCustomLabel(): void
    {
        $field = FileSizeField::new('fileSize', 'Custom Label');

        $this->assertSame('Custom Label', $field->getAsDto()->getLabel());
    }

    public function testGetFormatValue_withZeroBytes(): void
    {
        $result = FileSizeField::getFormatValue(0);

        $this->assertSame('0 B', $result);
    }

    public function testGetFormatValue_withSmallSize(): void
    {
        $result = FileSizeField::getFormatValue(1023);

        $this->assertSame('1 KB', $result);
    }

    public function testGetFormatValue_withKilobytes(): void
    {
        $result = FileSizeField::getFormatValue(1024);

        $this->assertSame('1 KB', $result);
    }

    public function testGetFormatValue_withMegabytes(): void
    {
        $result = FileSizeField::getFormatValue(1024 * 1024);

        $this->assertSame('1 MB', $result);
    }

    public function testGetFormatValue_withGigabytes(): void
    {
        $result = FileSizeField::getFormatValue(1024 * 1024 * 1024);

        $this->assertSame('1 GB', $result);
    }

    public function testGetFormatValue_withExceptionScenario(): void
    {
        // 可能导致异常的值（如负值）
        $result = FileSizeField::getFormatValue(-1);

        // 异常情况下应返回原始字节值
        $this->assertSame('-1 B', $result);
    }
}
