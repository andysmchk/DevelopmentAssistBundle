<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

class TemplateAggregate implements Template
{
    /**
     * @var Template
     */
    private $templates;

    public function addTemplate(Template $template): void
    {
        $this->templates[] = $template;
    }

    public function save(Writer $writer): void
    {
        foreach ($this->templates as $template) {
            $template->save($writer);
        }
    }
}
