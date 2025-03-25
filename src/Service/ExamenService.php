<?php

namespace App\Service;

use App\Entity\Examen;
use App\Entity\User;
use App\Repository\ExamenRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExamenService
{
    // Usamos la promoción de propiedades en el constructor para inyectar las dependencias
    public function __construct(private EntityManagerInterface $entityManager, private ExamenRepository $examenRepository)
    {
    }

    public function crearExamen(string $materia, float $nota, \DateTimeInterface $fecha, User $usuario): bool
    {
        try {
            $examen = new Examen();
            $examen->setMateria($materia);
            $examen->setNota($nota);
            $examen->setFecha($fecha);
            $examen->setUsuario($usuario);

            $this->entityManager->persist($examen);
            $this->entityManager->flush();

            return true;
        } catch (\Throwable $e) {
            // Si ocurre una excepción, podemos registrar un mensaje de error en algún log, si es necesario
            // Aquí podrías usar un sistema de logs como Monolog o similar
            return false;
        }
    }

    // Método para obtener todos los exámenes
    public function list(): array
    {
        return $this->examenRepository->findAll();
    }

    // Método para encontrar un examen por ID
    public function find(int $id): ?Examen
    {
        return $this->examenRepository->find($id);
    }

    /**
     * Obtener los exámenes de un usuario ordenados por materia y fecha.
     * El método fundbyuser viene del ExamenRepository
     */

    public function findByUser(User $user): array
    {
        return $this->examenRepository->findByUser($user);
    }


       /**
     * Eliminar un examen de la base de datos.
     */
    public function eliminarExamen(Examen $examen): bool
    {
        try {
            $this->entityManager->remove($examen);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            // Manejar el error si ocurre una excepción
        
            return false;
        }
    }
}