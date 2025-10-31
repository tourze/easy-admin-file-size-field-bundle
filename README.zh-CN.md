# EasyAdmin 文件大小字段扩展

[![PHP 版本](https://img.shields.io/badge/php-%5E8.1-blue.svg)](https://php.net/)
[![Symfony 版本](https://img.shields.io/badge/symfony-%5E6.4-green.svg)](https://symfony.com/)
[![许可证](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![构建状态](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![代码覆盖率](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](#)

[English](README.md) | [中文](README.zh-CN.md)

一个为 EasyAdmin 提供文件大小字段的 Symfony 扩展包，
自动将字节值格式化为人类可读的格式（KB、MB、GB 等）。

## 功能特性

- **自动格式化**：将原始字节值转换为人类可读的格式（B、KB、MB、GB、TB）
- **Twig 集成**：提供 `format_bytes` 过滤器供模板使用
- **易于集成**：与 EasyAdmin 的字段系统无缝集成
- **可定制**：支持所有标准 EasyAdmin 字段选项

## 安装

使用 Composer 安装扩展包：

```bash
composer require tourze/easy-admin-file-size-field-bundle
```

## 快速开始

在你的 EasyAdmin CRUD 控制器中，使用 `FileSizeField` 来显示文件大小：

```php
<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Tourze\EasyAdminFileSizeFieldBundle\Field\FileSizeField;
use App\Entity\File;

class FileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return File::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            FileSizeField::new('size', '文件大小'),
        ];
    }
}
```

## 使用方法

### 在 EasyAdmin 控制器中

```php
// 基本用法
FileSizeField::new('fileSize')

// 带自定义标签
FileSizeField::new('fileSize', '文档大小')

// 带额外选项
FileSizeField::new('fileSize', '大小')
    ->setHelp('上传文件的大小')
    ->hideOnIndex()
```

### 在 Twig 模板中

你也可以在 Twig 模板中直接使用 `format_bytes` 过滤器：

```html
{{ file.size|format_bytes }}
{# 输出: "1.5 MB" #}

{{ 1024|format_bytes }}
{# 输出: "1 KB" #}
```

## 高级用法

### 自定义格式化选项

`FileSizeField` 支持额外的配置选项：

```php
FileSizeField::new('fileSize')
    ->setTemplatePath('admin/custom_file_size.html.twig')
    ->addCssClass('file-size-custom')
    ->setFormTypeOptions([
        'precision' => 2,
        'binary' => true, // 使用 1024 而不是 1000 作为基数
    ])
```

### 表单类型集成

你也可以在表单中直接使用表单类型：

```php
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('maxFileSize', FileSizeType::class, [
            'label' => '最大文件大小',
        ])
    ;
}
```

## 配置

扩展包安装后会自动注册。无需额外配置。

## 系统要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- EasyAdmin 4.0 或更高版本

## 许可证

此扩展包基于 MIT 许可证发布。详情请参阅 [LICENSE](LICENSE) 文件。
