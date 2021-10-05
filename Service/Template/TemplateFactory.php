<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Render\Render;

class TemplateFactory
{
    /**
     * @var Render
     */
    private $render;

    public function __construct(Render $render)
    {
        $this->render = $render;
    }

    public function getTemplate(TemplateDefinition $definition, array $params): Template
    {
        $content = $this->render->renderTemplate($definition->getSourcePath(), $params);
        $destination = $this->render->render($definition->getDestinationPath(), $params);

        if ($definition->isModeAppend()) {
            return new AppendTemplate($destination, $content);
        }

        return new DumpTemplate($destination, $content);
    }
}