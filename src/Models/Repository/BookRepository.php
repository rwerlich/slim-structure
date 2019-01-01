<?php

namespace App\Models\Repository;

use Doctrine\ORM\EntityRepository;


class BookRepository extends EntityRepository
{

    public function customSearch(int $id)
    {
        $query = $this->em->createQuery('SELECT b FROM App\\Models\\Entity\\Book b WHERE b.id = :id');
        $query->setParameters(['id' => $id]);
        return $query->getResult();
    }

}