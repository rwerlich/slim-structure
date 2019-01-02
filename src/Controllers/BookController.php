<?php

namespace App\Controllers;

use App\Models\Entity\Book;
use App\Helpers\Book as BookHelper;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class BookController extends DefaultController
{

    public function find(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $booksRepository = $this->em->getRepository(Book::class);
        if(!$id){
            $books = $booksRepository->findAll();
            return $response->withJson(BookHelper::toArray($books), 200)
                ->withHeader('Content-type', 'application/json');
        }
        $book = $booksRepository->find($id);
        if (!$book) {
            throw new \Exception("Book not Found", 404);
        }
        return $response->withJson(BookHelper::toArray([$book]), 200)
            ->withHeader('Content-type', 'application/json');
    }

    public function save(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $params = (array) $request->getParsedBody();
        $booksRepository = $this->em->getRepository(Book::class);
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
        $book = $booksRepository->save($book);
        return $response->withJson($book, 201)
            ->withHeader('Content-type', 'application/json');
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $booksRepository = $this->em->getRepository(Book::class);
        $book = $booksRepository->find($id);
        if (!$book) {
            throw new \Exception("Book not Found", 404);
        }
        $booksRepository->delete($book);
        return $response->withJson(['msg' => "Book deleted {$id}"], 204)
            ->withHeader('Content-type', 'application/json');
    }


}