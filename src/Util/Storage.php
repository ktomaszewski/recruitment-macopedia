<?php

declare(strict_types=1);

namespace Application\Util;

use Symfony\Component\HttpKernel\KernelInterface;
use const DIRECTORY_SEPARATOR;

final class Storage
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    public function getPath(): string
    {
        return $this->kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR;
    }

    public function getProductPath(): string
    {
        return $this->getPath() . 'product' . DIRECTORY_SEPARATOR;
    }
}
