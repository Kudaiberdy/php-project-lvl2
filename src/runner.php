<?php
namespace Gendiff\Cli;
use function Gendiff\JsonDiffer\getJsonDiff;
use Docopt;

function run()
{
    $doc = <<<DOC
        Generate diff
        
        Usage:
          gendiff (-h|--help)
          gendiff [--format <fmt>] <firstFile> <secondFile>
          
        Options:
          -h --help                     Show this screen
          --format <fmt>                Report format [default: basic]

        DOC;

    $args = Docopt::handle($doc);
    $filePath1 = $args['<firstFile>'];
    $filePath2 = $args['<secondFile>'];
    $format = $args['--format'];

    $result = getJsonDiff($filePath1, $filePath2);

    echo $result;
}
