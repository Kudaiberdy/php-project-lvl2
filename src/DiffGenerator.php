<?php

namespace Gendiff\DiffGenerator;

function convertBoolToStr($arr)
{
    $convertedValues = [];
    foreach ($arr as $key => $value) {
        if (gettype($value) === 'boolean') {
            $convertedValues[$key] = $value === true ? 'true' : 'false';
        } else {
            $convertedValues[$key] = $value;
        }
    }
    return $convertedValues;
}

function getJsonDiff($pathOne, $pathTwo)
{
    if (file_exists($pathOne) === false || file_exists($pathTwo) === false) {
        return false;
    }

    $fileOne = convertBoolToStr(json_decode(file_get_contents($pathOne), true));
    $fileTwo = convertBoolToStr(json_decode(file_get_contents($pathTwo), true));

    $keys = collect(array_keys($fileOne))->merge(array_keys($fileTwo))->unique()->sort();

    $diff = $keys->reduce(function ($acc, $key) use ($fileOne, $fileTwo) {
        $acc->push(getTypes($key, $fileOne, $fileTwo));
        return $acc;
    }, collect())
        ->all();

    $res = [];

    $typeNode = [
        'unchanged' => fn($node) => "   {$node['key']}: {$node['value']}\n",
        'changed' => fn($node) => " - {$node['key']}: {$node['fileOne']}\n + {$node['key']}: {$node['fileTwo']}\n",
        'added' => fn($node) => " + {$node['key']}: {$node['value']}\n",
        'deleted' => fn($node) => " - {$node['key']}: {$node['value']}\n"
    ];

    foreach ($diff as $item) {
        $res[] = $typeNode[$item['type']]($item);
    }

//    var_dump();
    return implode('', $res);
}

function getTypes($key, $fileOne, $fileTwo)
{
    if (array_key_exists($key, $fileOne) === false) {
        return ['type' => 'added', 'key' => $key, 'value' => $fileTwo[$key]];
    }
    if (array_key_exists($key, $fileTwo) === false) {
        return ['type' => 'deleted', 'key' => $key, 'value' => $fileOne[$key]];
    }
    if (is_array($fileOne[$key]) && is_array($fileTwo[$key])) {
        return ['type' => 'parent', 'key' => $key, 'innerItem' => buildDiff($fileOne[$key], $fileTwo[$key])];
    }
    if ($fileOne[$key] === $fileTwo[$key]) {
        return ['type' => 'unchanged', 'key' => $key, 'value' => $fileOne[$key]];
    } else {
        return ['type' => 'changed', 'key' => $key, 'fileOne' => $fileOne[$key], 'fileTwo' => $fileTwo[$key]];
    }
}
