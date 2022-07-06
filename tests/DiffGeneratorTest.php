<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use Gendiff\DiffGenerator;

class DiffGeneratorTest extends TestCase
{
    public function testGetJsonDiff()
    {
        $actual = file_get_contents(__DIR__ . '/fixtures/expected/expectedFlatDiff');
        $expect = diffGenerator\getJsonDiff(__DIR__ . '/fixtures/file1.json', __DIR__ . '/fixtures/file2.json');
//        var_dump($expect);
        $this->assertEquals($expect, $actual);
    }
}
