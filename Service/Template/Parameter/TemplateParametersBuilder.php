<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Parameter;

interface TemplateParametersBuilder
{
    /**
     * @param InputParameter[] $inputParameters
     * @return array
     */
    public function buildParams(array $inputParameters): array;
}