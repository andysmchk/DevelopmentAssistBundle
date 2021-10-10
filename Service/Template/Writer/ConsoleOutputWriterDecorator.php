<?php

namespace Rewsam\DevelopmentAssist\Service\Template\Writer;

use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputWriterDecorator implements Writer
{
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var Writer
     */
    private $subject;

    public function __construct(Writer $subject, OutputInterface $output)
    {
        $this->output = $output;
        $this->subject = $subject;
    }

    public function exists(string $destination): bool
    {
        return $this->subject->exists($destination);
    }

    public function dump(string $destination, string $content): void
    {
        $this->subject->dump($destination, $content);

        $this->output->writeln('<info>Added new file: ' . $destination . '</info>');
        $this->output->writeln('<info>New File Content: ' . $content . '</info>', OutputInterface::OUTPUT_RAW | OutputInterface::VERBOSITY_VERY_VERBOSE);
    }

    public function append(string $destination, string $content): void
    {
        $this->subject->append($destination, $content);

        $this->output->writeln('<comment>Updated file: ' . $destination . '</comment>');
        $this->output->writeln('<comment>Updated content: ' . $content . '</comment>', OutputInterface::OUTPUT_RAW | OutputInterface::VERBOSITY_VERY_VERBOSE);
    }
}