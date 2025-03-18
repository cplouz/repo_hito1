<?php
namespace App\Service;

use App\Entity\Examen;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;


class ExamenService
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function crearExamen(string $materia, float $nota, \DateTimeInterface $fecha): bool
    {
        $usuario = $this->security->getUser();
        if (!$usuario) {
            return false;
        }

        $examen = new Examen();
        $examen->setMateria($materia);
        $examen->setNota($nota);
        $examen->setFecha($fecha);
        $examen->setUser($usuario);

        $this->entityManager->persist($examen);
        $this->entityManager->flush();

        return true;
    }
}
