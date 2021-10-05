<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

class DumpTemplate extends AbstractTemplate
{
    public function save(Writer $writer): void
    {
        $writer->dump($this->destination, $this->content);
    }
}
