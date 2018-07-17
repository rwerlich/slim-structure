<?php
use App\Models\Entity\Book;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
require 'bootstrap.php';

/**
 * Lista de todos os livros
 * @request curl -X GET http://localhost/slim-structure/book
 */
$app->get('/book', function (Request $request, Response $response) use ($app) {
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $books = $booksRepository->findAll();
    $return = $response->withJson($books, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Retornando mais informações do livro informado pelo id
 * @request curl -X GET http://localhost/slim-structure/book/1
 */
$app->get('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);
    /**
     * Verifica se existe um livro com a ID informada
     */
    if (!$book) {
        throw new \Exception("Book not Found", 404);
    }
    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Cadastra um novo <Livro></Livro>
 * No windows não aceita aspa simples
 * @request curl -X POST -d "{\"name\":\"O Oceano no Fim do Caminho\", \"author\":\"Neil Gaiman\"}" -H "Content-type: application/json" http://localhost/slim-structure/book
 */
$app->post('/book', function (Request $request, Response $response) use ($app) {
    $params = (object) $request->getParams();
    /**
     * Pega o Entity Manager do nosso Container
     */
    $entityManager = $this->get('em');
    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $book = (new Book())->setName($params->name)
        ->setAuthor($params->author);

    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();

    $logger = $this->get('logger');
    $logger->info('Book Created!', $book->getValues());

    $return = $response->withJson($book, 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Atualiza os dados de um livro
 * @request curl -X PUT http://localhost/slim-structure/book/1 -H "Content-type: application/json" -d "{\"name\":\"Deuses Americanos\", \"author\":\"Neil Gaiman\"}"
 */
$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    /**
     * Encontra o Livro no Banco
     */
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);

    /**
     * Monolog Logger
     */
    $logger = $this->get('logger');

    /**
     * Verifica se existe um livro com a ID informada
     */
    if (!$book) {
        $logger->warning("Book {$id} Not Found - Impossible to Update");    
        throw new \Exception("Book not Found", 404);
    }
    /**
     * Atualiza e Persiste o Livro com os parâmetros recebidos no request
     */
    $book->setName($request->getParam('name'))
        ->setAuthor($request->getParam('author'));
    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($book);
    $entityManager->flush();

    $logger->info("Book {$id} updated!", $book->getValues());

    $return = $response->withJson($book, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});
/**
 * Deleta o livro informado pelo ID
 * @request curl -X DELETE http://localhost/slim-structure/book/3
 */
$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    /**
     * Pega o ID do livro informado na URL
     */
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
     $logger = $this->get('logger');
    /**
     * Encontra o Livro no Banco
     */
    $entityManager = $this->get('em');
    $booksRepository = $entityManager->getRepository('App\Models\Entity\Book');
    $book = $booksRepository->find($id);
    /**
     * Verifica se existe um livro com a ID informada
     */
    if (!$book) {
        $logger->warning("Book {$id} not Found - Impossible to Delete");
        throw new \Exception("Book not Found", 404);
    }
    /**
     * Remove a entidade
     */
    $entityManager->remove($book);
    $entityManager->flush();
    $logger->info("Book {$id} deleted", $book->getValues());
    $return = $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * HTTP Auth - Autenticação minimalista para retornar um JWT
 * curl -u root:toor -X GET http://localhost/slim-structure/auth
 */
$app->get('/auth', function (Request $request, Response $response) use ($app) {
    $key = $this->get("secretkey");
    $token = array(
        "user" => "werlivh",
        "github" => "https://github.com/rwerlich"
    );
    $jwt = JWT::encode($token, $key);
    return $response->withJson(["auth-jwt" => $jwt], 200)
        ->withHeader('Content-type', 'application/json');   
});

$app->run();
