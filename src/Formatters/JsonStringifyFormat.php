<?php

namespace Gendiff\Formatters\JsonStringifyFormat;

function buildString($key, $value, $indent, $depth, $signNode = ' '): string
{
    $currentIndent = substr_replace(
        str_repeat($indent, $depth),
        $signNode,
        - 2,
        1
    );
    $bracketIndent = str_repeat($indent, $depth);

    if (!is_array($value)) {
        if (empty($value)) {
            return "{$currentIndent}{$key}:{$value}";
        }
        return "{$currentIndent}{$key}: {$value}";
    }

    $res = collect($value)->map(fn($innerValue, $innerKey)
        => buildString($innerKey, $innerValue, $indent, $depth + 1))
        ->all();

    return implode("\n", ["{$currentIndent}{$key}: {", ...$res, "{$bracketIndent}}"]);
}

function buildStringNodeByType($node, $tabIndent, $depth): string|array
{
    $key = $node['key'];

    switch ($node['type']) {
        case 'unchanged':
            return buildString($key, $node['value'], $tabIndent, $depth);
        case 'added':
            return buildString($key, $node['value'], $tabIndent, $depth, '+');
        case 'deleted':
            return buildString($key, $node['value'], $tabIndent, $depth, '-');
        case 'changed':
            return [
                buildString($key, $node['firstFile'], $tabIndent, $depth, '-'),
                buildString($key, $node['secondFile'], $tabIndent, $depth, '+')
            ];
    }
}

function stringify($node): string
{
    $baseIndent = '    ';
    $stringDiffBuilder = function ($nodes, $depth = 1) use (&$stringDiffBuilder, $baseIndent) {
        $bracketIndent = str_repeat($baseIndent, $depth - 1);
        $parentIndent = str_repeat($baseIndent, $depth);

        $acc = collect($nodes)
            ->map(function ($node) use ($stringDiffBuilder, $baseIndent, $depth, $parentIndent) {
                if ($node['type'] === 'parent') {
                    return "{$parentIndent}{$node['key']}: " . $stringDiffBuilder($node['innerItem'], $depth + 1);
                }
                return buildStringNodeByType($node, $baseIndent, $depth);
            })
            ->flatten()
            ->all();

        $res = ["{", ...$acc, "{$bracketIndent}}"];
        return implode("\n", $res);
    };
    return $stringDiffBuilder($node) . "\n";
}