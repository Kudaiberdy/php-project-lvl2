<?php

namespace Gendiff\DiffGenerator;

use function Gendiff\Parser\parseFile;

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

function getDifference($pathOne, $pathTwo)
{
    $fileOne = convertBoolToStr(parseFile($pathOne));
    $fileTwo = convertBoolToStr(parseFile($pathTwo));

    $keys = collect(array_keys($fileOne))->merge(array_keys($fileTwo))->unique()->sort();

    $nodes = $keys->reduce(function ($acc, $key) use ($fileOne, $fileTwo) {
        $acc[] = getTypesOfNodes($key, $fileOne, $fileTwo);
        return $acc;
    }, []);
    return $nodes;
}

function getTypesOfNodes($key, $fileOne, $fileTwo)
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
