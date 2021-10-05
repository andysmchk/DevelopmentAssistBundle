<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use PHPUnit\Framework\MockObject\MockObject;
use Rewsam\DevelopmentAssist\Service\Template\AppendTemplate;
use Rewsam\DevelopmentAssist\Service\Template\DumpTemplate;
use Rewsam\DevelopmentAssist\Service\Template\Render\Render;
use Rewsam\DevelopmentAssist\Service\Template\Template;
use Rewsam\DevelopmentAssist\Service\Template\TemplateDefinition;
use Rewsam\DevelopmentAssist\Service\Template\TemplateFactory;
use PHPUnit\Framework\TestCase;

class TemplateFactoryTest extends TestCase
{
    public function testGetTemplateCorrectDumpFlow(): void
    {
        $templateDefinition = $this->createMock(TemplateDefinition::class);
        $templateDefinition->method('isModeAppend')->willReturn(false);
        $templateDefinition->method('isModeDump')->willReturn(true);

        self::assertInstanceOf(DumpTemplate::class, $this->getTemplate($templateDefinition));
    }

    public function testGetTemplateCorrectAppendFlow(): void
    {
        $templateDefinition = $this->createMock(TemplateDefinition::class);
        $templateDefinition->method('isModeAppend')->willReturn(true);
        $templateDefinition->method('isModeDump')->willReturn(false);

        self::assertInstanceOf(AppendTemplate::class, $this->getTemplate($templateDefinition));
    }

    /** @param MockObject|TemplateDefinition $templateDefinition */
    private function getTemplate($templateDefinition): Template
    {
        $params = ['param1' => 1, 'param2' => 2];
        $sourcePath = 'path/to/template';
        $destinationPath = 'lorem/ipsum';
        $content = 'template result';
        $renderedName = 'lorem/ipsum/foo/bar';

        $render = $this->createMock(Render::class);
        $render->expects($this->once())->method('renderTemplate')->with($sourcePath, $params)->willReturn($content);
        $render->expects($this->once())->method('render')->with($destinationPath, $params)->willReturn($renderedName);

        $templateDefinition->method('getDestinationPath')->willReturn($destinationPath);
        $templateDefinition->method('getSourcePath')->willReturn($sourcePath);

        $factory = new TemplateFactory($render);
        return $factory->getTemplate($templateDefinition, $params);
    }
}
