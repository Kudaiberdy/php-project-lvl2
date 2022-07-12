<?php

namespace Gendiff\Parser;

use mysql_xdevapi\Exception;
use Symfony\Component\Yaml\Yaml;

function parseFile($path)
{
    $pathInfo = pathinfo($path);
    $realpath = realpath($path);
    if (!file_exists($realpath)) {
        throw new \Exception("Specified files not exists\n");
    }

    $fileExtension = $pathInfo['extension'];
    $fileExtension = $fileExtension === 'yml' ? 'yaml' : $fileExtension;
    $data = file_get_contents($realpath);

    $extensionDispatcher = [
        'json' => fn($data) => json_decode($data, true),
        'yaml' => fn($data) => Yaml::parse($data)
    ];

    return $extensionDispatcher[$fileExtension]($data);
}
