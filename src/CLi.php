<?php

namespace Gendiff\Cli;

use Docopt;

use function Gendiff\Runner\run;

function runCli(): void
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
    $result = run($firstFile, $secondFile, $format);
    echo $result;
}
