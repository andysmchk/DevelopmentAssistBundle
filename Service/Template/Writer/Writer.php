<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Writer;

interface Writer
{
    public function exists(string $destination): bool;

    public function dump(string $destination, string $content): void;

    public function append(string $destination, string $content): void;

    public function isDirectory(string $destination): bool;
}