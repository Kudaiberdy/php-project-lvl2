<?php

namespace Gendiff\Formatters\JsonFormat;

function getDiffJsonFormat($diff)
{
    return json_encode($diff) . "\n";
}
