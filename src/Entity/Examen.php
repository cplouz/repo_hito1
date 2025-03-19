<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamenRepository::class)]
class Examen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $materia = null; // Se cambió "Materia" por "materia"

    #[ORM\Column]
    private ?float $nota = null; // Se cambió "Nota" por "nota"

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null; // Se cambió "Fecha" por "fecha"

    #[ORM\ManyToOne(inversedBy: 'examenes')] // Cambié el nombre de la propiedad inversa de 'Examen' a 'examenes'
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null; // Se cambió "User" por "user"

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateria(): ?string
    {
        return $this->materia; // Se cambió "Materia" por "materia"
    }

    public function setMateria(string $materia): static
    {
        $this->materia = $materia; // Se cambió "Materia" por "materia"

        return $this;
    }

    public function getNota(): ?float
    {
        return $this->nota; // Se cambió "Nota" por "nota"
    }

    public function setNota(float $nota): static
    {
        $this->nota = $nota; // Se cambió "Nota" por "nota"

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha; // Se cambió "Fecha" por "fecha"
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha; // Se cambió "Fecha" por "fecha"

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user; // Se cambió "User" por "user"
    }

    public function setUser(?User $user): static
    {
        $this->user = $user; // Se cambió "User" por "user"

        return $this;
    }
}