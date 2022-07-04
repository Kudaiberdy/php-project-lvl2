<?php
namespace Gendiff\Cli;

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
//    dump('_______', $args, '________');
    $filePath1 = $args['<firstFile>'];
    $filePath2 = $args['<secondFile>'];
    $format = $args['--format'];

    $result = generateDiff($filePath1, $filePath2, $format);
    echo $result;
}
