<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

interface Template
{
    public function save(Writer $writer): void;
}
