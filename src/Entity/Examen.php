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

    #[ORM\Column(length: 50)]
    private ?string $materia = null;

    #[ORM\Column]
    private ?float $nota = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'editar')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateria(): ?string
    {
        return $this->materia;
    }

    public function setMateria(string $materia): static
    {
        $this->materia = $materia;

        return $this;
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $nota): static
    {
        $this->nota = $nota;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
