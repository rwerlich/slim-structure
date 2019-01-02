<?php

namespace App\Models\Repository;

use Doctrine\ORM\EntityRepository;
use App\Models\Entity\Book;
use Doctrine\ORM\Mapping;


class BookRepository extends EntityRepository
{


    public function save(Book $entity)
    {
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
            return $entity;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete(Book $entity)
    {
        try {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
            return $entity;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function customSearch(int $id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT b FROM App\\Models\\Entity\\Book b WHERE b.id = :id');
        $query->setParameters(['id' => $id]);
        return $query->getResult();
    }

}