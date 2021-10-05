<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Writer;

use Symfony\Component\Console\Output\OutputInterface;

class WriterBuilder
{
    /**
     * @var OutputInterface|null $output
     */
    private $output;

    /**
     * @var bool
     */
    private $dry = false;

    /**
     * @var bool
     */
    private $override = true;

    public function build(): Writer
    {
        $writer = new FilesystemWriter($this->dry, $this->override);

        if ($this->output) {
            $writer = new ConsoleOutputWriterDecorator($writer, $this->output);
        }

        return $writer;
    }

    public function setOutput(?OutputInterface $output): WriterBuilder
    {
        $this->output = $output;
        return $this;
    }

    public function setDry(bool $dry): WriterBuilder
    {
        $this->dry = $dry;
        return $this;
    }

    public function setOverride(bool $override): WriterBuilder
    {
        $this->override = $override;
        return $this;
    }
}