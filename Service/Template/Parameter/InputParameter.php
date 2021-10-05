<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

final class InputParameter extends InputParameterDefinition
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $name, string $key, string $value)
    {
        parent::__construct($name, $key);
        $this->value = $value;
    }

    public static function createFromDefinition(InputParameterDefinition $definition, string $value): InputParameter
    {
        return new self($definition->getName(), $definition->getKey(), $value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}