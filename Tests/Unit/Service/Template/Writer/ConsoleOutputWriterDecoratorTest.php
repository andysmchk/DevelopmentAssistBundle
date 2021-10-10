<?php

namespace Rewsam\DevelopmentAssist\Tests\Service\Template\Writer;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Rewsam\DevelopmentAssist\Service\Template\Writer\ConsoleOutputWriterDecorator;
use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class ConsoleOutputWriterDecoratorTest extends TestCase
{
    use ProphecyTrait;

    /** @var Writer|ObjectProphecy */
    private $writer;
    /** @var ConsoleOutputInterface|ObjectProphecy */
    private $output;

    public function setUp(): void
    {
        $this->writer = $this->prophesize(Writer::class);
        $this->output = $this->prophesize(ConsoleOutputInterface::class);
        $this->output->writeln(Argument::any(), Argument::any());

    }

    public function testExists(): void
    {
        $destination = 'path';
        $this->writer->exists($destination)->shouldBeCalledOnce();
        $writer = new ConsoleOutputWriterDecorator($this->writer->reveal(), $this->output->reveal());
        $writer->exists($destination);
    }

    public function testAppend(): void
    {
        $destination = 'path';
        $content = 'foobar';
        $this->writer->append($destination, $content)->shouldBeCalledOnce();
        $writer = new ConsoleOutputWriterDecorator($this->writer->reveal(), $this->output->reveal());
        $writer->append($destination, $content);
    }

    public function testDump(): void
    {
        $destination = 'path';
        $content = 'foobar';
        $this->writer->dump($destination, $content)->shouldBeCalledOnce();
        $writer = new ConsoleOutputWriterDecorator($this->writer->reveal(), $this->output->reveal());
        $writer->dump($destination, $content);
    }
}
