<?php

namespace Gendiff\Formatters\JsonFormat;

function getDiffJsonFormat($diff): string
{
    return json_encode($diff) . "\n";
}
