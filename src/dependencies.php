<?php
use Psr\Container\ContainerInterface;
use Notes\Core\Database\ConnectDb;
use Notes\Core\Validators\JsonValidator;
// DIC configuration
$container = $app->getContainer();

// monolog
$container['logger'] = function (ContainerInterface $container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container[Notes\Services\Models\NotesModel::class] = function (ContainerInterface $container){
    return new Notes\Services\Models\NotesModel($container);
};

$container[Notes\Services\Models\UserModel::class] = function (ContainerInterface $container){
    return new Notes\Services\Models\UserModel($container);
};

$container["pdoObject"] = function(ContainerInterface $container){
    return ConnectDb::getInstance();
};

$container['jsonValidator'] = function (ContainerInterface $container) {
    return new JsonValidator();
};

