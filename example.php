<?php

require_once 'vendor/autoload.php';
use Ivanb\FolderNesting\FolderNesting;

$directories = [
    'test',
    'test2'
];

$parser = new FolderNesting();

echo $parser->getSumNumbersInFiles($directories);