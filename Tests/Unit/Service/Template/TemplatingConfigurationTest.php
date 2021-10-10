<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Service\Template;

use Rewsam\DevelopmentAssist\Service\Template\TemplatingConfiguration;
use PHPUnit\Framework\TestCase;

class TemplatingConfigurationTest extends TestCase
{
    /**
     * @dataProvider emptyConfigurationProvider
     */
    public function testEmptyConfigurationNoExceptions(array $configuration): void
    {
        $subject = new TemplatingConfiguration($configuration);

        self::assertEmpty($subject->getInputParameterDefinitions());
        self::assertEmpty(iterator_to_array($subject->getTemplateDefinitions()));
    }

    public function testGetInputParameterDefinitions(): void
    {
        $configuration = [
            'parameters' => [
                ['name' => 'Foo', 'key' => 'foo'],
                ['name' => 'Bar', 'key' => 'bar'],
            ]
        ];
        $subject = new TemplatingConfiguration($configuration);

        foreach ($subject->getInputParameterDefinitions() as $index => $parameterDefinition) {
            $parameterConfiguration = $configuration['parameters'][$index];
            self::assertSame($parameterConfiguration['key'], $parameterDefinition->getKey());
            self::assertSame($parameterConfiguration['name'], $parameterDefinition->getName());
        }
        self::assertEmpty(iterator_to_array($subject->getTemplateDefinitions()));
    }

    public function emptyConfigurationProvider(): array
    {
        return [
            [[]],
            [['parameters' => [], 'destinations' => []]]
        ];
    }

    /**
     * @dataProvider templateDefinitionsProvider
     */
    public function testGetTemplateDefinitions(array $destinations, array $expected): void
    {
        $configuration = [
            'destinations' => $destinations
        ];
        $subject = new TemplatingConfiguration($configuration);

        foreach ($subject->getTemplateDefinitions() as $index => $templateDefinition) {
            $expect = $expected[$index];
            self::assertSame($expect[0], $templateDefinition->getSourcePath(), 'SourcePath is wrong');
            self::assertSame($expect[1], $templateDefinition->getDestinationPath(), 'DestinationPath is wrong');
            self::assertSame($expect[2], $templateDefinition->isModeDump(), 'isModeDump');
            self::assertSame($expect[3], $templateDefinition->isModeAppend(), 'isModeAppend');
        }


    }

    public function templateDefinitionsProvider(): iterable
    {
        yield [
            [
                'foo' => [
                    'files_source_path' => 'sourceFolder',
                    'destination_path' => 'destinationFolder',
                    'write_mode' => 'dump',
                    'files' => [
                        'sourceFileName1' => 'destinationFilename1',
                        'sourceFileName2' => 'destinationFilename2',
                    ]
                ]
            ],
            [
                //SourcePath, DestinationPath, isModeDump, isModeAppend
                ['sourceFolder/sourceFileName1', 'destinationFolder/destinationFilename1', true, false],
                ['sourceFolder/sourceFileName2', 'destinationFolder/destinationFilename2', true, false]
            ]
        ];

        yield [
            [
                'foo' => [
                    'files_source_path' => 'sourceFolder',
                    'destination_path' => 'destination.yml',
                    'write_mode' => 'dump',
                    'files' => [
                        'sourceFileName1',
                        'sourceFileName2',
                    ]
                ]
            ],
            [
                //SourcePath, DestinationPath, isModeDump, isModeAppend
                ['sourceFolder/sourceFileName1', 'destination.yml', true, false],
                ['sourceFolder/sourceFileName2', 'destination.yml', true, false]
            ]
        ];

        yield [
            [
                'foo' => [
                    'files_source_path' => '',
                    'destination_path' => '',
                    'write_mode' => 'dump',
                    'files' => [
                        'sourceFileName1' => 'destinationFilename1',
                        'sourceFileName2' => 'destinationFilename2',
                    ]
                ]
            ],
            [
                //SourcePath, DestinationPath, isModeDump, isModeAppend
                ['sourceFileName1', 'destinationFilename1', true, false],
                ['sourceFileName2', 'destinationFilename2', true, false]
            ]
        ];

        yield [
            [
                'foo' => [
                    'files_source_path' => '',
                    'destination_path' => 'destination',
                    'write_mode' => 'append',
                    'files' => [
                        'sourceFileName1',
                        'sourceFileName2' => 'destinationFilename2',
                    ]
                ]
            ],
            [
                //SourcePath, DestinationPath, isModeDump, isModeAppend
                ['sourceFileName1', 'destination', false, true],
                ['sourceFileName2', 'destination/destinationFilename2', false, true]
            ]
        ];

        yield [
            [
                'foo' => [
                    'files_source_path' => 'sourceFolder',
                    'destination_path' => 'destinationFolder',
                    'write_mode' => 'dump',
                    'files' => [
                        'sourceFileName1' => 'destinationFilename1',
                    ]
                ],
                'bar' => [
                    'files_source_path' => '',
                    'destination_path' => 'destinationFolder',
                    'write_mode' => 'append',
                    'files' => [
                        'sourceFileName2' => 'destinationFilename2',
                    ]
                ]
            ],
            [
                //SourcePath, DestinationPath, isModeDump, isModeAppend
                ['sourceFolder/sourceFileName1', 'destinationFolder/destinationFilename1', true, false],
                ['sourceFileName2', 'destinationFolder/destinationFilename2', false, true]
            ]
        ];
    }
}
