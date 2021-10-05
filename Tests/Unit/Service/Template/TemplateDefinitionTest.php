<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\TemplateDefinition;
use PHPUnit\Framework\TestCase;

class TemplateDefinitionTest extends TestCase
{
    /**
     * @dataProvider modeProvider
     */
    public function testCreateWithModes(bool $isModeDump, bool $isModeAppend, string $mode): void
    {
        $source = 'source';
        $destination = 'dest';

        $definition = new TemplateDefinition($destination, $source, $mode);
        self::assertSame($destination, $definition->getDestinationPath());
        self::assertSame($source, $definition->getSourcePath());
        self::assertSame($isModeDump, $definition->isModeDump());
        self::assertSame($isModeAppend, $definition->isModeAppend());
    }

    public function testWrongMode(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new TemplateDefinition('dest', 'source', 'boop');
    }

    public function modeProvider(): array
    {
        return [
            [false, true, TemplateDefinition::SAVE_MODE_APPEND],
            [true, false, TemplateDefinition::SAVE_MODE_DUMP],
        ];
    }
}
