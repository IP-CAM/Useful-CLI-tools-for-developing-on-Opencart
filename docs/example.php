#!/usr/bin/env php
<?php

date_default_timezone_set('UTC');
set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';

use Ocli\Command\Module\CreateCommand;
use Symfony\Component\Console\Application;

$application = new Application('Ocli', '0.1');
$application->add(new CreateCommand);
$application->run();
