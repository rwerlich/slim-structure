<?php
require 'vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;


/**
 * Configurações
 */
$configs = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
/**
 * Container Resources do Slim.
 * Aqui dentro dele vamos carregar todas as dependências
 * da nossa aplicação que vão ser consumidas durante a execução
 * da nossa API
 */
$container = new \Slim\Container($configs);
/**
 * Converte os Exceptions entro da Aplicação em respostas JSON
 */
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $c['response']->withStatus($statusCode)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

/**
 * Converte os Exceptions de Erros 404 - Not Found
 */
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(['message' => 'Page not found']);
    };
};

/**
 * Converte os Exceptions de Erros 405 - Not Allowed
 */
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);

$conn = [
    'dbname' => 'api',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

$entityManager = EntityManager::create($conn, $config);
$container['em'] = $entityManager;

$app = new \Slim\App($container);

