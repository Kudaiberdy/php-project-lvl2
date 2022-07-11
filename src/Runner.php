<?php

namespace Gendiff\Runner;

use function Gendiff\DiffGenerator\getDifference;
use function Gendiff\DiffBuilder\buildDiff;
use function Gendiff\Parser\parseFile;

function run($pathToFirstFile, $pathToSecondFile, $format): string
{
    $dataFirstFile = parseFile($pathToFirstFile);
    $dataSecondFile = parseFile($pathToSecondFile);
    $arrayOfDiff = getDifference($dataFirstFile, $dataSecondFile);

    return buildDiff($arrayOfDiff, $format);
}
