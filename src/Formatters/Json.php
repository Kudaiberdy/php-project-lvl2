<?php

namespace Gendiff\Formatters\Json;

/**
 * @param array $diff
 * @return string
 */
function getJsonFormat(array $nodes): string
{
    return json_encode($nodes) . "\n";
}
