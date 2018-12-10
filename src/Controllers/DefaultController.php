<?php

namespace App\Controllers;

use Doctrine\ORM\EntityManager;

abstract class DefaultController
{

    private $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getDoctrine(){
        return $this->doctrine;
    }

}