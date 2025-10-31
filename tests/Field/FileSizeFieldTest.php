<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\Tests\Field;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

/**
 * @internal
 */
#[CoversClass(FileSizeField::class)]
final class FileSizeFieldTest extends TestCase
{
    public function testNewWithValidPropertyName(): void
    {
        $field = FileSizeField::new('fileSize');

        $this->assertInstanceOf(FileSizeField::class, $field);
        $this->assertSame('fileSize', $field->getAsDto()->getProperty());
        $this->assertSame(FileSizeType::class, $field->getAsDto()->getFormType());
        $this->assertSame('@EasyAdminFileSizeField/file_size.html.twig', $field->getAsDto()->getTemplatePath());
        $this->assertStringContainsString('field-file-size', $field->getAsDto()->getCssClass());
    }

    public function testNewWithNullLabel(): void
    {
        $field = FileSizeField::new('fileSize', null);

        $this->assertNull($field->getAsDto()->getLabel());
    }

    public function testNewWithCustomLabel(): void
    {
        $field = FileSizeField::new('fileSize', 'Custom Label');

        $this->assertSame('Custom Label', $field->getAsDto()->getLabel());
    }

    public function testGetFormatValueWithZeroBytes(): void
    {
        $result = FileSizeField::getFormatValue(0);

        $this->assertSame('0 B', $result);
    }

    public function testGetFormatValueWithSmallSize(): void
    {
        $result = FileSizeField::getFormatValue(1023);

        $this->assertSame('1 KB', $result);
    }

    public function testGetFormatValueWithKilobytes(): void
    {
        $result = FileSizeField::getFormatValue(1024);

        $this->assertSame('1 KB', $result);
    }

    public function testGetFormatValueWithMegabytes(): void
    {
        $result = FileSizeField::getFormatValue(1024 * 1024);

        $this->assertSame('1 MB', $result);
    }

    public function testGetFormatValueWithGigabytes(): void
    {
        $result = FileSizeField::getFormatValue(1024 * 1024 * 1024);

        $this->assertSame('1 GB', $result);
    }

    public function testGetFormatValueWithExceptionScenario(): void
    {
        // 可能导致异常的值（如负值）
        $result = FileSizeField::getFormatValue(-1);

        // 异常情况下应返回原始字节值
        $this->assertSame('-1 B', $result);
    }

    public function testAddAssetMapperEntries(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addAssetMapperEntries('test.js', 'another.js');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddCssClass(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addCssClass('custom-class');

        $this->assertInstanceOf(FileSizeField::class, $result);
        $this->assertStringContainsString('custom-class', $field->getAsDto()->getCssClass());
    }

    public function testAddCssFiles(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addCssFiles('custom.css', 'another.css');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddFormTheme(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addFormTheme('custom_theme.html.twig');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddHtmlContentsToBody(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addHtmlContentsToBody('<script>test</script>');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddHtmlContentsToHead(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addHtmlContentsToHead('<meta name="test">');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddJsFiles(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->addJsFiles('custom.js', 'another.js');

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testAddWebpackEncoreEntries(): void
    {
        $field = FileSizeField::new('fileSize');

        // 由于 Webpack Encore 未安装，这个方法会抛出 RuntimeException
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('You are trying to add Webpack Encore entries in a field but Webpack Encore is not installed in your project');

        $field->addWebpackEncoreEntries('app', 'admin');
    }

    public function testFormatValue(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->formatValue(function ($value) {
            return 'custom:' . (is_numeric($value) ? (string) $value : '0');
        });

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testHideOnDetail(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->hideOnDetail();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testHideOnForm(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->hideOnForm();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testHideOnIndex(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->hideOnIndex();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testHideWhenCreating(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->hideWhenCreating();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testHideWhenUpdating(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->hideWhenUpdating();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testOnlyOnDetail(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->onlyOnDetail();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testOnlyOnForms(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->onlyOnForms();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testOnlyOnIndex(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->onlyOnIndex();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testOnlyWhenCreating(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->onlyWhenCreating();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }

    public function testOnlyWhenUpdating(): void
    {
        $field = FileSizeField::new('fileSize');
        $result = $field->onlyWhenUpdating();

        $this->assertInstanceOf(FileSizeField::class, $result);
    }
}
