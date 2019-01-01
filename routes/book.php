<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/books[/{id}]', function (Request $request, Response $response) {
    return $this->BookController->findAll($request, $response);
});

$app->post('/books', function (Request $request, Response $response) use ($app) {
    return $this->BookController->save($request, $response);
});

$app->put('/books/{id}', function (Request $request, Response $response) use ($app) {
    return $this->BookController->save($request, $response);
});

$app->delete('/books/{id}', function (Request $request, Response $response) use ($app) {
    return $this->BookController->delete($request, $response);
});

