<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use Prophecy\PhpUnit\ProphecyTrait;
use Rewsam\DevelopmentAssist\Service\Template\AppendTemplate;
use Rewsam\DevelopmentAssist\Service\Template\DumpTemplate;
use Rewsam\DevelopmentAssist\Service\Template\Template;
use Rewsam\DevelopmentAssist\Service\Template\TemplateAggregate;
use PHPUnit\Framework\TestCase;
use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

class TemplateTest extends TestCase
{
    use ProphecyTrait;

    public function testDumpTemplate(): void
    {
        $content = 'foo';
        $destination = 'bar';
        $template = new DumpTemplate($destination, $content);
        $writer = $this->prophesize(Writer::class);
        $writer->dump($destination, $content)->shouldBeCalledOnce();
        $template->save($writer->reveal());
    }

    public function testAppendTemplate(): void
    {
        $content = 'foo';
        $destination = 'bar';
        $template = new AppendTemplate($destination, $content);
        $writer = $this->prophesize(Writer::class);
        $writer->append($destination, $content)->shouldBeCalledOnce();
        $template->save($writer->reveal());
    }
}
