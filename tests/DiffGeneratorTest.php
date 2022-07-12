<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Parser\parseFile;
use function Gendiff\Runner\run;

class DiffGeneratorTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testRecursiveFile($pathToFirstFile, $pathToSecondFile, $pathToExpect)
    {
        $expect = file_get_contents($pathToExpect);
        $actual = run(
            $pathToFirstFile,
            $pathToSecondFile,
            'basic'
        );
        $this->assertEquals($expect, $actual);
    }

    public function additionProvider()
    {
        return [
            'jsonStringify1' => [
                __DIR__ . "/fixtures/file1.json",
                __DIR__ . "/fixtures/file2.json",
                __DIR__ . "/fixtures/expected/expectedJsonStringify.txt"
            ],
            'jsonStringify2' => [
                __DIR__ . "/fixtures/file1.yaml",
                __DIR__ . "/fixtures/file2.yaml",
                __DIR__ . "/fixtures/expected/expectedJsonStringify.txt"
            ],
            'jsonStringify3' => [
                __DIR__ . "/fixtures/file1.yml",
                __DIR__ . "/fixtures/file2.yml",
                __DIR__ . "/fixtures/expected/expectedJsonStringify.txt"
            ]

        ];
    }
    public function testParserWrongPath()
    {
        $this->expectException(\Exception::class);
        $actual = parseFile('/wrong/path');
    }
}
