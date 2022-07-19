<?php

namespace Gendiff\Cli;

use Docopt;

use function Gendiff\Runner\run;

function runCli(): void
{
    $doc = <<<DOC
        Compares two configuration files and shows a difference.
        
        Usage:
          gendiff (-h|--help)
          gendiff (-v|--version)
          gendiff [-f|--format <fmt>] <firstFile> <secondFile>
          
        Options:
          -h --help                     Show this screen
          -v --version                  Show version
          -f --format <fmt>             Report format [default: stylish]
        DOC;

    $args = Docopt::handle($doc, ['version' => 'gendiff version 1.0.0']);
    $firstFile = $args['<firstFile>'];
    $secondFile = $args['<secondFile>'];
    $format = $args['--format'][0];
    $result = '';

    try {
        $result = run($firstFile, $secondFile, $format);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

    echo $result;
}
