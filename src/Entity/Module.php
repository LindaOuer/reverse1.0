<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Module
{

    #[ORM\Id]
    #[ORM\Column(type: "string", length: 50)]
    private string $Code;

    #[ORM\Column(type: "string", length: 200)]
    private string $Nom;

    #[ORM\Column(type: "integer")]
    private int $ECTS;

    public function getCode()
    {
        return $this->Code;
    }

    public function setCode($value)
    {
        $this->Code = $value;
    }

    public function getNom()
    {
        return $this->Nom;
    }

    public function setNom($value)
    {
        $this->Nom = $value;
    }

    public function getECTS()
    {
        return $this->ECTS;
    }

    public function setECTS($value)
    {
        $this->ECTS = $value;
    }
}
