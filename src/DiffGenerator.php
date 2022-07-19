<?php

namespace Gendiff\DiffGenerator;

function stringifyValues(array $arr): array
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

function getDifference(array $arrayFirst, array $arraySecond): array
{
    $fileOne = stringifyValues($arrayFirst);
    $fileTwo = stringifyValues($arraySecond);
    $keys = collect(array_keys($fileOne))->merge(array_keys($fileTwo))->unique()->sort();

    return $keys->reduce(function ($acc, $key) use ($fileOne, $fileTwo) {
        $acc[] = getTypesOfNodes($key, $fileOne, $fileTwo);
        return $acc;
    }, []);
}

function getTypesOfNodes($key, array $firstArray, array $secondArray): array
{
    if (array_key_exists($key, $firstArray) === false) {
        return [
            'type' => 'added',
            'key' => $key,
            'value' => $secondArray[$key]
        ];
    }
    if (array_key_exists($key, $secondArray) === false) {
        return [
            'type' => 'deleted',
            'key' => $key,
            'value' => $firstArray[$key]
        ];
    }
    if (is_array($firstArray[$key]) && is_array($secondArray[$key])) {
        return [
            'type' => 'parent',
            'key' => $key,
            'innerItem' => getDifference($firstArray[$key], $secondArray[$key])
        ];
    }
    if ($firstArray[$key] === $secondArray[$key]) {
        return [
            'type' => 'unchanged',
            'key' => $key,
            'value' => $firstArray[$key]
        ];
    } else {
        return [
            'type' => 'changed',
            'key' => $key,
            'firstFile' => $firstArray[$key],
            'secondFile' => $secondArray[$key]
        ];
    }
}
