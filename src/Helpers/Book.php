<?php

namespace App\Helpers;


class Book
{

    public static function toArray(array $books){
        $result = [];
        foreach ($books as $book){
            $result[] = ['id' => $book->getId(),
                        'name' => $book->getName(),
                        'author' => $book->getAuthor(),
                        ];
        }
        return $result;
    }


}