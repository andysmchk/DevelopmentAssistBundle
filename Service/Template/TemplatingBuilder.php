<?php

namespace Rewsam\DevelopmentAssist\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;
use Symfony\Component\Console\Output\OutputInterface;

class TemplatingBuilder
{
    /**
     * @var Writer
     */
    public $writer;
    /**
     * @var OutputInterface
     */
    public $output;

    public function setWriter(Writer $writer): void
    {
        $this->writer = $writer;
    }

    public function addConsoleOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function addTemplateType(): void
    {

    }
}