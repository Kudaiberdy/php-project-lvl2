<?php

namespace Gendiff\DiffBuilder;

use function Gendiff\Formatters\Stylish\getStylishFormat;
use function Gendiff\Formatters\Json\getJsonFormat;
use function Gendiff\Formatters\Plain\getPlainFormat;

function buildDiff(array $arrayOfNodes, string $format): string
{
    $typeNode = [
        'stylish' => fn($arrayOfNodes) => getStylishFormat($arrayOfNodes),
        'json' => fn($arrayOFNodes) => getJsonFormat($arrayOfNodes),
        'plain' => fn($arrayOFNodes) => getPlainFormat($arrayOfNodes)
    ];

    return $typeNode[$format]($arrayOfNodes);
}
