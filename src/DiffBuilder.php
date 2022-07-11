<?php

namespace Gendiff\DiffBuilder;

use function Gendiff\Formatters\JsonStringifyFormat\stringify;
use function Gendiff\Formatters\JsonFormat\getDiffJsonFormat;

function buildDiff($arrayOfNodes, $format): string
{
    $typeNode = [
        'basic' => fn($arrayOfNodes) => stringify($arrayOfNodes),
        'json' => fn($arrayOFNodes) => getDiffJsonFormat($arrayOfNodes)
    ];

    return $typeNode[$format]($arrayOfNodes);
}
