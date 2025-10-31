# EasyAdmin File Size Field Bundle

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue.svg)](https://php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-%5E6.4-green.svg)](https://symfony.com/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](#)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](#)

[English](README.md) | [中文](README.zh-CN.md)

A Symfony bundle that provides a file size field for EasyAdmin, automatically 
formatting byte values into human-readable formats (KB, MB, GB, etc.).

## Features

- **Automatic formatting**: Converts raw byte values into human-readable formats (B, KB, MB, GB, TB)
- **Twig integration**: Provides a `format_bytes` filter for use in templates
- **Easy integration**: Works seamlessly with EasyAdmin's field system
- **Customizable**: Supports all standard EasyAdmin field options

## Installation

Install the bundle using Composer:

```bash
composer require tourze/easy-admin-file-size-field-bundle
```

## Quick Start

In your EasyAdmin CRUD controller, use the `FileSizeField` to display file sizes:

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
            FileSizeField::new('size', 'File Size'),
        ];
    }
}
```

## Usage

### In EasyAdmin Controllers

```php
// Basic usage
FileSizeField::new('fileSize')

// With custom label
FileSizeField::new('fileSize', 'Document Size')

// With additional options
FileSizeField::new('fileSize', 'Size')
    ->setHelp('The size of the uploaded file')
    ->hideOnIndex()
```

### In Twig Templates

You can also use the `format_bytes` filter directly in your Twig templates:

```html
{{ file.size|format_bytes }}
{# Output: "1.5 MB" #}

{{ 1024|format_bytes }}
{# Output: "1 KB" #}
```

## Advanced Usage

### Custom Formatting Options

The `FileSizeField` supports additional configuration options:

```php
FileSizeField::new('fileSize')
    ->setTemplatePath('admin/custom_file_size.html.twig')
    ->addCssClass('file-size-custom')
    ->setFormTypeOptions([
        'precision' => 2,
        'binary' => true, // Use 1024 instead of 1000 as base
    ])
```

### Form Type Integration

You can also use the form type directly in your forms:

```php
use Tourze\EasyAdminFileSizeFieldBundle\Form\FileSizeType;

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('maxFileSize', FileSizeType::class, [
            'label' => 'Maximum File Size',
        ])
    ;
}
```

## Configuration

The bundle registers itself automatically when installed. No additional configuration is required.

## Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher
- EasyAdmin 4.0 or higher

## License

This bundle is released under the MIT license. See the [LICENSE](LICENSE) file for details.