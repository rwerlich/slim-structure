<?php

namespace App\Models\Repository;

use Doctrine\ORM\EntityRepository;
use App\Models\Entity\Book;


class BookRepository extends EntityRepository
{

    public function save(Book $entity)
    {
        try {
            $this->em->persist($entity);
            $this->em->flush();
            return $entity;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete(Book $entity)
    {
        try {
            $this->em->remove($entity);
            $this->em->flush();
            return $entity;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function customSearch(int $id)
    {
        $query = $this->em->createQuery('SELECT b FROM App\\Models\\Entity\\Book b WHERE b.id = :id');
        $query->setParameters(['id' => $id]);
        return $query->getResult();
    }

}