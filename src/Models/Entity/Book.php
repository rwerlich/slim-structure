<?php
namespace App\Models\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity @Table(name="books")
 * @ORM @Entity(repositoryClass="App\Models\Repository\BookRepository")
 **/
class Book {
    /**
     * @var int
     * @Id @Column(type="integer") 
     * @GeneratedValue
     */
    private $id;
    /**
     * @var string
     * @Column(type="string") 
     */
    private $name;
    /**
     * @var string
     * @Column(type="string") 
     */
    private $author;
    /**
     * @return int id
     */
    public function getId(){
        return $this->id;
    }
    /**
     * @return string name
     */
    public function getName(){
        return $this->name;
    }
    /**
     * @return string author
     */
    public function getAuthor() {
        return $this->author;
    }    
    /**
     * @return App\Models\Entity\Book
     */
    public function setName($name){
        if (!$name && !is_string($name)) {
            throw new \InvalidArgumentException("Book name is required", 400);
        }
        $this->name = $name;
        return $this;  
    }
     /**
     * @return App\Models\Entity\Book
     */
    public function setAuthor($author) {
        if (!$author && !is_string($author)) {
            throw new \InvalidArgumentException("Author is required", 400);
        }
        $this->author = $author;
        return $this;
    }
    /**
     * @return App\Models\Entity\Book
     */
    public function getValues() {
        return get_object_vars($this);
    }
}

