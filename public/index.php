<?php

declare(strict_types=1);

use App\Handler\DefaultHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/hello/{name}', DefaultHandler::class);

$app->run();