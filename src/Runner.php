<?php

namespace Gendiff\Runner;

use function Gendiff\DiffCalculator\calculateDiff;
use function Gendiff\DiffBuilder\buildDiff;
use function Gendiff\Parser\parseFile;

/**
 * @param string $pathToFirstFile
 * @param string $pathToSecondFile
 * @param string $format
 * @return string
 * @throws \Exception
 */
function run(string $pathToFirstFile, string $pathToSecondFile, string $format): string
{
    $dataFirstFile = parseFile($pathToFirstFile);
    $dataSecondFile = parseFile($pathToSecondFile);
    $arrayOfDiff = calculateDiff($dataFirstFile, $dataSecondFile);

    return buildDiff($arrayOfDiff, $format);
}
