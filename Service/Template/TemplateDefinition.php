<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

class TemplateDefinition
{
    public const SAVE_MODE_APPEND = 'append';
    public const SAVE_MODE_DUMP   = 'dump';

    public const SAVE_MODES = [
        self::SAVE_MODE_APPEND,
        self::SAVE_MODE_DUMP,
    ];

    /**
     * @var string
     */
    private $destinationPath;
    /**
     * @var string
     */
    private $sourcePath;
    /**
     * @var string
     */
    private $mode;

    public function __construct(string $destinationPath, string $sourcePath, string $mode)
    {
        $this->destinationPath = $destinationPath;
        $this->sourcePath = $sourcePath;
        $this->mode = $mode;

        if (!in_array($mode, self::SAVE_MODES)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid mode given expected one of: %s, but %s was given instead', implode(', ', self::SAVE_MODES), $mode)
            );
        }
    }

    public function getDestinationPath(): string
    {
        return $this->destinationPath;
    }

    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    public function isModeAppend(): bool
    {
        return $this->mode === self::SAVE_MODE_APPEND;
    }

    public function isModeDump(): bool
    {
        return $this->mode === self::SAVE_MODE_DUMP;
    }
}
