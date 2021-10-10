<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Writer;

use Symfony\Component\Filesystem\Filesystem;

class SimpleFilesystemAdapter
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public static function create(): self
    {
        return new self(new Filesystem());
    }

    public function exists(string $destination): bool
    {
        return $this->filesystem->exists($destination);
    }

    public function writeTo(string $destination, string $content): void
    {
        $this->filesystem->dumpFile($destination, $content);
    }

    public function readFrom(string $destination): string
    {
        return file_get_contents($destination);
    }

    public function isDirectory(string $destination): string
    {
        return is_dir($destination);
    }
}