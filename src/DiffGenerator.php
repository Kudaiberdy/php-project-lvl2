<?php

namespace Gendiff\DiffGenerator;

function convertBoolToStr($arr)
{
    $convertedValues = [];
    foreach ($arr as $key => $value) {
        if (gettype($value) === 'boolean') {
            $convertedValues[$key] = $value === true ? 'true' : 'false';
        } elseif ($value === null) {
            $convertedValues[$key] = 'null';
        } else {
            $convertedValues[$key] = $value;
        }
    }
    return $convertedValues;
}

function getDifference($arrayFirst, $arraySecond): array
{
    $fileOne = convertBoolToStr($arrayFirst);
    $fileTwo = convertBoolToStr($arraySecond);
    $keys = collect(array_keys($fileOne))->merge(array_keys($fileTwo))->unique()->sort();

    return $keys->reduce(function ($acc, $key) use ($fileOne, $fileTwo) {
        $acc[] = getTypesOfNodes($key, $fileOne, $fileTwo);
        return $acc;
    }, []);
}

function getTypesOfNodes($key, $fileOne, $fileTwo): array
{
    if (array_key_exists($key, $fileOne) === false) {
        return ['type' => 'added', 'key' => $key, 'value' => $fileTwo[$key]];
    }
    if (array_key_exists($key, $fileTwo) === false) {
        return ['type' => 'deleted', 'key' => $key, 'value' => $fileOne[$key]];
    }
    if (is_array($fileOne[$key]) && is_array($fileTwo[$key])) {
        return ['type' => 'parent', 'key' => $key, 'innerItem' => getDifference($fileOne[$key], $fileTwo[$key])];
    }
    if ($fileOne[$key] === $fileTwo[$key]) {
        return ['type' => 'unchanged', 'key' => $key, 'value' => $fileOne[$key]];
    } else {
        return ['type' => 'changed', 'key' => $key, 'firstFile' => $fileOne[$key], 'secondFile' => $fileTwo[$key]];
    }
}
