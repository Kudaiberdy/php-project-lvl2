<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;

use function Gendiff\DiffGenerator\getDifference;
use function Gendiff\Parser\parseFile;
use function Gendiff\DiffBuilder\buildDiff;

class DiffGeneratorTest extends TestCase
{
    public function testGetJsonDiff()
    {
        $expect = file_get_contents(__DIR__ . '/fixtures/expected/expectedFlatDiff');
        $actual = getDifference(
            __DIR__ . '/fixtures/flatFile1.json',
            __DIR__ . '/fixtures/flatFile2.json'
        );
        $res = buildDiff($actual);
        $this->assertEquals($expect, $res);
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

        $this->assertFalse(parseFile('./tests/fixture/flatFile1.json'));
    }
}
