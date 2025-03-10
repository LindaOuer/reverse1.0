<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Note
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $note;

    #[ORM\Column(type: "string", length: 10)]
    private string $student;

    #[ORM\Column(type: "string", length: 50)]
    private string $module;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date_note;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($value)
    {
        $this->note = $value;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($value)
    {
        $this->student = $value;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setModule($value)
    {
        $this->module = $value;
    }

    public function getDate_note()
    {
        return $this->date_note;
    }

    public function setDate_note($value)
    {
        $this->date_note = $value;
    }
}
