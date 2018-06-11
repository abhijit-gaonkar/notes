<?php

use Tuupola\Middleware\HttpBasicAuthentication\PdoAuthenticator;
use Notes\Core\Database;

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/notes",
    "realm" => "Protected",
    "authenticator" => new PdoAuthenticator([
    "pdo" => Database\ConnectDb::getInstance()->getConnection(),
    "user" => "email",
    "hash" => "password",
    "table" => "user"
])
]));

