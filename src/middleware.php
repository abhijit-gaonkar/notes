<?php

use Tuupola\Middleware\HttpBasicAuthentication\PdoAuthenticator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/notes",
    "realm" => "Protected",
    "authenticator" => new PdoAuthenticator([
    "pdo" => $app->getContainer()->get("pdoObject")->getConnection(),
    "user" => "email",
    "hash" => "password",
    "table" => "user"
])
]));

