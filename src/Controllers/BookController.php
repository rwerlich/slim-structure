<?php

namespace App\Controllers;

use App\Models\Entity\Book;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class BookController extends DefaultController
{

    public function findAll(Request $request, Response $response)
    {
        $booksRepository = $this->getDoctrine()->getRepository(Book::class);
        $books = $booksRepository->findAll();
        return $response->withJson($books, 200)
            ->withHeader('Content-type', 'application/json');
    }

    public function find(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $booksRepository = $this->getDoctrine()->getRepository(Book::class);
        $book = $booksRepository->find($id);
        if (!$book) {
            throw new \Exception("Book not Found", 404);
        }
        return $response->withJson($book, 200)
            ->withHeader('Content-type', 'application/json');
    }

    public function save(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $params = (array) $request->getParsedBody();
        $entityManager = $this->getDoctrine();
        $booksRepository = $entityManager->getRepository(Book::class);
        if($id){
            $book = $booksRepository->find($id);
            if (!$book) {
                throw new \Exception("Book not Found", 404);
            }
        }else{
            $book = new Book();
        }
        $book->setName($params['name'])
            ->setAuthor($params['author']);
        $entityManager->persist($book);
        $entityManager->flush();
        return $response->withJson($book, 201)
            ->withHeader('Content-type', 'application/json');
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $entityManager = $this->getDoctrine();
        $booksRepository = $entityManager->getRepository(Book::class);
        $book = $booksRepository->find($id);
        if (!$book) {
            throw new \Exception("Book not Found", 404);
        }
        $entityManager->remove($book);
        $entityManager->flush();
        return $response->withJson(['msg' => "Deletando o livro {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
    }


}