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
        // Obtener el usuario actual desde el sistema de seguridad
        $usuario = $this->security->getUser();
        if (!$usuario) {
            return false; // Si no hay usuario autenticado, no crear el examen
        }

        // Crear el nuevo objeto Examen
        $examen = new Examen();
        $examen->setMateria($materia);
        $examen->setNota($nota);
        $examen->setFecha($fecha);
        $examen->setUser($usuario); // Asignamos el usuario al examen

        // Persistimos y guardamos el examen en la base de datos
        $this->entityManager->persist($examen);
        $this->entityManager->flush();

        return true; // El examen ha sido creado exitosamente
    }
}
