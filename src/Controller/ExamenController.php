<?php

namespace App\Controller;

use App\Service\ExamenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExamenController extends AbstractController
{
    #[Route('/examen', name: 'app_examen')]
    public function index(): Response
    {
        return $this->render('examen/index.html.twig', [
            'controller_name' => 'ExamenController',
        ]);
    }

    #[Route('/examen/crear', name: 'examen_crear', methods: ['POST'])]
    public function crear(Request $request, ExamenService $examenService): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error', 'Debes iniciar sesión para crear un examen.');
            return $this->redirectToRoute('app_login');
        }

        try {
            $materia = $request->request->get('materia');
            $nota = (float) $request->request->get('nota');
            $fecha = new \DateTime($request->request->get('fecha'));

            if (!$examenService->crearExamen($materia, $nota, $fecha)) {
                throw new \Exception("No se pudo crear el examen.");
            }

            $this->addFlash('success', 'Examen creado con éxito.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Error al crear el examen: ' . $e->getMessage());
        }

        return $this->redirectToRoute('home');
    }





}
