<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Parameter\InputParameterDefinition;

class TemplatingConfiguration
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @var InputParameterDefinition[]|null
     */
    private $parameters;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return InputParameterDefinition[]
     */
    public function getInputParameterDefinitions(): array
    {
        if ($this->parameters !== null) {
            return $this->parameters;
        }
        $this->parameters = [];

        foreach ($this->configuration['parameters'] as $parameter) {
            $this->parameters[] = new InputParameterDefinition($parameter['name'], $parameter['key']);
        }

        return $this->parameters;
    }

    public function getTemplateDefinitions(): iterable
    {
        foreach ($this->configuration['destinations'] as $sectionName => $config) {
            $sourcePath = $config['files_source_path'];
            $destinationPath = $config['destination_path'];
            $writeMode = $config['write_mode'];
            $files = $config['files'];

            //Example: ControllerV1: '{ENTITY_NAME}ControllerV1.php'
            foreach ($files as $sourceFileName => $destinationFileName) {
                $destination = sprintf('%s/%s', $destinationPath, $destinationFileName);
                $source = sprintf('%s/%s', $sourcePath, $sourceFileName);

                if (is_numeric($sourceFileName)) {
                    $source = sprintf('%s/%s', $sourcePath, $destinationFileName);
                    $destination = $destinationPath;
                }

                yield new TemplateDefinition($destination, $source, $writeMode);
            }
        }
    }
}