<?php

namespace Gendiff\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile($path)
{
    $pathInfo = pathinfo($path);
    $realpath = realpath($path);
//    dump(__DIR__);
    if (!file_exists($realpath)) {
        return false;
    }


    $fileExtension = $pathInfo['extension'];
    $fileExtension = $fileExtension === 'yml' ?: 'yaml';
    $data = file_get_contents($realpath);

    $extensionDispatcher = [
        'json' => fn($data) => json_decode($data, true),
        'yaml' => fn($data) => Yaml::parse($data)
    ];

    return $extensionDispatcher[$fileExtension]($data);
}