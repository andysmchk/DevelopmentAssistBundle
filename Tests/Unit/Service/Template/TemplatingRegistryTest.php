<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use Prophecy\PhpUnit\ProphecyTrait;
use Rewsam\DevelopmentAssist\Service\Template\Templating;
use Rewsam\DevelopmentAssist\Service\Template\TemplatingRegistry;
use PHPUnit\Framework\TestCase;

class TemplatingRegistryTest extends TestCase
{
    use ProphecyTrait;

    public function testHasItemAfterAdd(): void
    {
        $templating = $this->prophesize(Templating::class)
                           ->reveal();

        $subject = new TemplatingRegistry();
        $subject->add('foo', $templating);

        self::assertSame(['foo'], $subject->getKeys());
        self::assertSame($templating, $subject->get('foo'));
    }

    public function testDoesNotHaveItem(): void
    {
        $subject = new TemplatingRegistry();

        self::assertSame([], $subject->getKeys());
        $this->expectException(\InvalidArgumentException::class);
        $subject->get('foo');
    }
}
