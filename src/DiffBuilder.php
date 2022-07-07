<?php

namespace Gendiff\DiffBuilder;

function buildDiff($arrayOfNodes)
{
    $res = [];

    $typeNode = [
        'unchanged' => fn($node) => "   {$node['key']}: {$node['value']}\n",
        'changed' => fn($node) => " - {$node['key']}: {$node['fileOne']}\n + {$node['key']}: {$node['fileTwo']}\n",
        'added' => fn($node) => " + {$node['key']}: {$node['value']}\n",
        'deleted' => fn($node) => " - {$node['key']}: {$node['value']}\n"
    ];

    foreach ($arrayOfNodes as $node) {
        $res[] = $typeNode[$node['type']]($node);
    }
    return implode('', $res);
}
