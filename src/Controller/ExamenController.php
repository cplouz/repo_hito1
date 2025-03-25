<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Service\ExamenService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[IsGranted('ROLE_USER')]

final class ExamenController extends AbstractController
{
    #[Route('/examen', name: 'app_examen')]
    public function index(): Response
    {
        return $this->render('examen/index.html.twig', [
            'controller_name' => 'ExamenController',
        ]);
    }

    

    
    #[Route('/examen/nuevo', name: 'crear_examen')]  

    public function new(Request $request, ValidatorInterface $validator, ExamenService $examenService): Response
    {
        $examen = new Examen();

        if ($request->getMethod() === 'POST') {
            try {
                $materia = $request->request->get('materia', "");
                $nota = (float) $request->request->get('nota', 0);
                $fecha = $request->request->get('fecha', "");

                if (!$fecha) {
                    throw new \Exception("La fecha no puede estar vacía.");
                }

                $examen->setMateria($materia);
                $examen->setNota($nota);
                $examen->setFecha(new DateTime($fecha));
                $examen->setUsuario($this->getUser());

                $errores = []; // Inicializo array vacio, porque si no hay errores la funcion de count me dará error 


                $errores = $validator->validate($examen);

                if (count($errores) > 0) {
                    foreach ($errores as $error) {
                        $this->addFlash("warning", $error->getMessage());
                    }
                    return $this->render('examen/crear.html.twig', ['examen' => $examen]);
                } else {
                    $examenService->crearExamen($materia, $nota, new DateTime($fecha), $this->getUser());
                    $this->addFlash('success', 'Examen guardado correctamente');
                    return $this->redirectToRoute('app_examen');
                }
            } catch (\Throwable $e) {
                $this->addFlash('danger', 'Error al crear el examen: ' . $e->getMessage());
                return $this->render('examen/crear.html.twig', ['examen' => $examen]);
            }
        } else {
            return $this->render('examen/crear.html.twig', [
                'controller_name' => 'ExamenController',
                'examen' => $examen
            ]);
        }
    }



    #[Route('/examen/list', name: 'app_examen_list')]
    public function list(ExamenService $examenService): Response
    {
        // Obtén el usuario autenticado
        $user = $this->getUser();

        // Llama al servicio para obtener los exámenes del usuario, ordenados
        $examenes = $examenService->findByUser($user);

        // Renderiza la vista con los exámenes obtenidos
        return $this->render('examen/list.html.twig', [
            'examenes' => $examenes
        ]);
    }


    #[Route('/examen/eliminar/{id}', name: 'eliminar_examen', methods: ['POST'])]
    public function eliminarExamen(int $id, ExamenService $examenService): Response
    {
        // Verificar si el usuario está autenticado
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Debes estar autenticado para realizar esta acción.');
            return $this->redirectToRoute('app_login'); // Redirigir a la página de login
        }

        // Intentar encontrar el examen por su ID
        $examen = $examenService->find($id);
        if (!$examen) {
            $this->addFlash('danger', 'El examen no existe o ha sido eliminado previamente.');
            return $this->redirectToRoute('app_examen_list'); // Redirigir al listado de exámenes
        }

        // Comprobar si el examen pertenece al usuario autenticado
        if ($examen->getUsuario() !== $user) {
            $this->addFlash('danger', 'No tienes permiso para eliminar este examen.');
            return $this->redirectToRoute('app_examen_list'); // Redirigir al listado de exámenes
        }

        try {
            // Eliminar el examen
            $examenService->eliminarExamen($examen);
            $this->addFlash('success', 'Examen eliminado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre cualquier excepción
            $this->addFlash('danger', 'Ocurrió un error al intentar eliminar el examen.'. $e->getMessage());
        }

        return $this->redirectToRoute('app_examen_list'); // Redirigir al listado de exámenes
    }




}
