<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Writer;

use Symfony\Component\Filesystem\Filesystem;

class FilesystemWriter implements Writer
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var bool
     */
    private $dry;
    /**
     * @var bool
     */
    private $override;

    public function __construct(bool $dry, bool $override)
    {
        $this->filesystem = new Filesystem();
        $this->dry = $dry;
        $this->override = $override;
    }

    public function exists(string $destination): bool
    {
        return $this->filesystem->exists($destination);
    }

    public function dump(string $destination, string $content): void
    {
        if (!$this->override && $this->exists($destination)) {
            return;
        }

        if (!$this->dry) {
            $this->filesystem->mkdir(dirname($destination));
            $this->filesystem->dumpFile($destination, $content);
        }
    }

    public function append(string $destination, string $content): void
    {
        if (!$this->dry) {
            $original = file_get_contents($destination);
            $content = str_replace($content, '', $original) . $content;

            $this->filesystem->dumpFile($destination, $content);
        }
    }

    public function isDirectory(string $destination): bool
    {
        return $destination === dirname($destination);
    }
}