<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

class TemplatingRegistry
{
    /**
     * @var Templating[]
     */
    private $storage = [];

    public function add(string $templateName, Templating $templating)
    {
        $this->storage[$templateName] = $templating;
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->storage);
    }

    public function get(string $templateName): Templating
    {
        if (!isset($this->storage[$templateName])) {
            throw new \InvalidArgumentException('Given template name is not supported');
        }

        return $this->storage[$templateName];
    }
}