<?php

namespace Rewsam\DevelopmentAssist\Tests\Unit\Helper;

use Rewsam\DevelopmentAssist\Service\Helper\StringCaseConversion;
use PHPUnit\Framework\TestCase;

class StringCaseConversionTest extends TestCase
{
    /** @dataProvider camelToDashProvider */
    public function testCamelToDash(string $test, string $expected)
    {
        self::assertSame($expected, StringCaseConversion::camelToDash($test));
    }
    /** @dataProvider camelToWordsProvider */
    public function testCamelToWords(string $test, string $expected): void
    {
        self::assertSame($expected, StringCaseConversion::camelToWords($test));
    }
    /** @dataProvider underscoreToCamelProvider */
    public function testUnderscoreToCamel(string $test, string $expected): void
    {
        self::assertSame($expected, StringCaseConversion::underscoreToCamel($test));
    }

    public function camelToWordsProvider(): array
    {
        return [
            ['camel', 'Camel'],
            ['camelCase', 'Camel Case'],
            ['camelCase', 'Camel Case'],
            ['camelCaseIsAwesome', 'Camel Case Is Awesome'],
            ['camelCase fooBar', 'Camel Case Foo Bar'],
            ['not-came-cased', 'Not-came-cased'],
            ['camelCaseIsAwesome not-came-cased', 'Camel Case Is Awesome Not-came-cased'],
        ];
    }

    public function underscoreToCamelProvider(): array
    {
        return [
            ['camel', 'camel'],
            ['camelCase', 'camelCase'],
            ['underscored_line', 'underscoredLine'],
            ['underscored_line underscored_line', 'underscoredLine underscoredLine'],
        ];
    }

    public function camelToDashProvider(): array
    {
        return [
            ['camel', 'camel'],
            ['camelCase', 'camel-case'],
            ['camelCaseIsAwesome', 'camel-case-is-awesome'],
            ['camelCase fooBar', 'camel-case foo-bar'],
            ['not-came-cased', 'not-came-cased'],
            ['camelCaseIsAwesome not-came-cased', 'camel-case-is-awesome not-came-cased'],
        ];
    }
}
