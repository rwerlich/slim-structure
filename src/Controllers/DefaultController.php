<?php

namespace App\Controllers;

use Doctrine\ORM\EntityManager;

abstract class DefaultController
{

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

}