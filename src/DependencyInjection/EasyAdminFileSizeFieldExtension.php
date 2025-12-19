<?php

declare(strict_types=1);

namespace Tourze\EasyAdminFileSizeFieldBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

final class EasyAdminFileSizeFieldExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__ . '/../Resources/config';
    }
}
