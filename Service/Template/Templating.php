<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Parameter\InputParameter;
use Rewsam\DevelopmentAssist\Service\Template\Parameter\InputParameterDefinition;
use Rewsam\DevelopmentAssist\Service\Template\Parameter\TemplateParametersBuilder;

class Templating
{
    /**
     * @var TemplateParametersBuilder
     */
    private $builder;
    /**
     * @var TemplateFactory
     */
    private $factory;
    /**
     * @var TemplatingConfiguration
     */
    private $configuration;

    public function __construct(TemplatingConfiguration $configuration, TemplateParametersBuilder $builder, TemplateFactory $factory)
    {
        $this->builder = $builder;
        $this->factory = $factory;
        $this->configuration = $configuration;
    }

    /**
     * @return InputParameterDefinition[]
     */
    public function getInputParameterDefinitions(): array
    {
        return $this->configuration->getInputParameterDefinitions();
    }

    /**
     * @param InputParameter[] $inputParameters
     */
    public function prepare(array $inputParameters): Template
    {
        $this->validateInputParams($inputParameters);
        $params = $this->builder->buildParams($inputParameters);
        $aggregate = new TemplateAggregate();

        foreach ($this->configuration->getTemplateDefinitions() as $templateDefinition) {
            $template = $this->factory->getTemplate($templateDefinition, $params);
            $aggregate->addTemplate($template);
        }

        return $aggregate;
    }

    private function validateInputParams(array $inputParameters): void
    {
        $valid = false;

        foreach ($this->getInputParameterDefinitions() as $requiredParam) {
            $valid = false;
            foreach ($inputParameters as $inputParameter) {
                if ($inputParameter->getKey() === $requiredParam->getKey() && $inputParameter->getValue()) {
                    $valid = true;

                    continue 2;
                }
            }
        }

        if (!$valid) {
            throw new \InvalidArgumentException('Some parameters are invalid');
        }
    }
}