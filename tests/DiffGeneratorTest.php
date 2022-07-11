<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\Parser\parseFile;
use function Gendiff\Runner\run;

class DiffGeneratorTest extends TestCase
{
    public function testFlatFile()
    {
        $expect = file_get_contents(__DIR__ . '/fixtures/expected/expectedFlatDiff');
        $actual = run(
            __DIR__ . '/fixtures/flatFile1.json',
            __DIR__ . '/fixtures/flatFile2.json',
            'basic'
        );
        $this->assertEquals($expect, $actual);
    }

    public function testRecursiveFile()
    {
        $expect = file_get_contents(__DIR__ . '/fixtures/expected/expectedRecursiveDiff');
        $actual = run(
            __DIR__ . '/fixtures/recursiveFile1.json',
            __DIR__ . '/fixtures/recursiveFile2.json',
            'basic'
        );
        $this->assertEquals($expect, $actual);
    }

    public function testParser()
    {
        $expect = [
            "host" => "hexlet.io",
            "timeout" => 50,
            "proxy" => "123.234.53.22",
            "follow" => false
        ];
        $actual = parseFile(__DIR__ . '/fixtures/flatFile1.yaml');

        $this->assertEquals($expect, $actual);
        $this->assertFalse(parseFile('./wrong/path'));
    }
}
