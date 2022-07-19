<?php

namespace Gendiff\DiffBuilder;

use function Gendiff\Formatters\JsonStringifyFormat\stringify;
use function Gendiff\Formatters\JsonFormat\getDiffJsonFormat;

function buildDiff(array $arrayOfNodes, string $format): string
{
    $typeNode = [
        'stylish' => fn($arrayOfNodes) => stringify($arrayOfNodes),
        'json' => fn($arrayOFNodes) => getDiffJsonFormat($arrayOfNodes)
    ];

    return $typeNode[$format]($arrayOfNodes);
}
