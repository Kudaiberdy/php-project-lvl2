<?php

namespace Gendiff\Formatters\Json;

function getJsonFormat($diff): string
{
    return json_encode($diff) . "\n";
}
