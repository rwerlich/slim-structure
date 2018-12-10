<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/books', function (Request $request, Response $response) {
    return $this->BookController->findAll($request, $response);
});

$app->get('/book/{id}', function (Request $request, Response $response) use ($app) {
    return $this->BookController->find($request, $response);
});

$app->post('/book', function (Request $request, Response $response) use ($app) {
    return $this->BookController->save($request, $response);
});

$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    return $this->BookController->save($request, $response);
});


$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    return $this->BookController->delete($request, $response);
});

