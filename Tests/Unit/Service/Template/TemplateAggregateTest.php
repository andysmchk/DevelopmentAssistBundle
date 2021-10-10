<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use Prophecy\PhpUnit\ProphecyTrait;
use Rewsam\DevelopmentAssist\Service\Template\Template;
use Rewsam\DevelopmentAssist\Service\Template\TemplateAggregate;
use PHPUnit\Framework\TestCase;
use Rewsam\DevelopmentAssist\Service\Template\Writer\Writer;

class TemplateAggregateTest extends TestCase
{
    use ProphecyTrait;

    public function testWriterIsCalledOnEachTemplate(): void
    {
        $writer = $this->prophesize(Writer::class)->reveal();

        $aggregate = new TemplateAggregate();

        for ($i=0; $i<5; $i++) {
            $template = $this->prophesize(Template::class);
            $template->save($writer)->shouldBeCalledOnce();
            $aggregate->addTemplate($template->reveal());
        }

        $aggregate->save($writer);
    }
}
