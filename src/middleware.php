<?php

use Tuupola\Middleware\HttpBasicAuthentication\PdoAuthenticator;

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    "path" => "/notes",
    "realm" => "Protected",
    "authenticator" => new PdoAuthenticator([
        "pdo" => $app->getContainer()->get("pdoObject")->getConnection(),
        "user" => "user",
        "password" => "password"
    ])
]));