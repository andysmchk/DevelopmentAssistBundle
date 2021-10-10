<?php

namespace Rewsam\DevelopmentAssist\Tests\Service\Template\Writer;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Rewsam\DevelopmentAssist\Service\Template\Writer\ConsoleOutputWriterDecorator;
use Rewsam\DevelopmentAssist\Service\Template\Writer\FilesystemWriter;
use Rewsam\DevelopmentAssist\Service\Template\Writer\WriterBuilder;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

class WriterBuilderTest extends TestCase
{
    use ProphecyTrait;

    /** @dataProvider optionsProvider */
    public function testBuild(bool $dry, bool $override, ?ConsoleOutputInterface $output, string $expectedClass): void
    {
        $builder = new WriterBuilder();
        $builder->setDry($dry);
        $builder->setOverride($override);
        $builder->setOutput($output);

        self::assertSame($expectedClass, get_class($builder->build()));
    }

    public function optionsProvider(): iterable
    {
        $console = $this->prophesize(ConsoleOutputInterface::class)->reveal();

        foreach ([true, false] as $override) {
            foreach ([true, false] as $dry) {
                yield [
                    $dry,
                    $override,
                    null,
                    FilesystemWriter::class
                ];

                yield [
                    $dry,
                    $override,
                    $console,
                    ConsoleOutputWriterDecorator::class
                ];
            }
        }
    }
}
