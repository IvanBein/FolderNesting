<?php

require_once 'vendor/autoload.php';
use Ivanb\FolderNesting\FolderNesting;

$directories = [
    'testOne',
    'testTwo'
];

$parser = new FolderNesting();

echo $parser->getSumNumbersInFiles($directories);