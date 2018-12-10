<?php

namespace App\Models\Repository;

use Doctrine\ORM\EntityRepository;


class BookRepository extends EntityRepository
{

    public function customSearch()
    {
        $id = 1;
        //$this->getEntityManager()->createQuery('sql')->setParameter('id', $id)->getResult();
        return 0;
    }

}