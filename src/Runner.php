<?php

namespace Gendiff\Runner;

use Docopt;

use function Gendiff\DiffGenerator\getDifference;
use function Gendiff\DiffBuilder\buildDiff;
use function Gendiff\Parser\parseFile;

function run(): void
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
    $firstFile = $args['<firstFile>'];
    $secondFile = $args['<secondFile>'];
    $format = $args['--format'];
    dump($secondFile);
//    $parsedFile1 = parseFile($firstFile);
//    $parsedFile2 = parseFile($secondFile);
    $nodes = getDifference($firstFile, $secondFile);

    $result = buildDiff($nodes);
    echo $result;
}
