<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Student
{

    #[ORM\Id]
    #[ORM\Column(type: "string", length: 10)]
    private string $NSC;

    #[ORM\Column(type: "string", length: 250)]
    private string $email;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "integer")]
    private int $idclasse;

    public function getNSC()
    {
        return $this->NSC;
    }

    public function setNSC($value)
    {
        $this->NSC = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getIdclasse()
    {
        return $this->idclasse;
    }

    public function setIdclasse($value)
    {
        $this->idclasse = $value;
    }
}
