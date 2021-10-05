<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

class SimpleTemplateParametersBuilder implements TemplateParametersBuilder
{
    /**
     * @param InputParameter[] $inputParameters
     * @return array
     */
    public function buildParams(array $inputParameters): array
    {
        $params = [];

        foreach ($inputParameters as $inputParameter) {
            $params[$inputParameter->getKey()] = $inputParameter->getValue();
        }

        return $params;
    }
}