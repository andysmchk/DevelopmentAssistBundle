<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

class InputParameterDefinition
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $key;

    public function __construct(string $name, string $key)
    {
        $this->name = $name;
        $this->key = $key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}