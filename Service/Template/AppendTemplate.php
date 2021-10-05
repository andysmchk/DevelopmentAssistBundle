<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

class AppendTemplate extends AbstractTemplate
{
    public function save(Writer $writer): void
    {
        $writer->append($this->destination, $this->content);
    }
}
