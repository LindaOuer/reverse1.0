<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Classe
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $idclasse;

    #[ORM\Column(type: "string", length: 100)]
    private string $Nom;

    #[ORM\Column(type: "integer")]
    private int $Niveau;

    public function getIdclasse()
    {
        return $this->idclasse;
    }

    public function setIdclasse($value)
    {
        $this->idclasse = $value;
    }

    public function getNom()
    {
        return $this->Nom;
    }

    public function setNom($value)
    {
        $this->Nom = $value;
    }

    public function getNiveau()
    {
        return $this->Niveau;
    }

    public function setNiveau($value)
    {
        $this->Niveau = $value;
    }
}
