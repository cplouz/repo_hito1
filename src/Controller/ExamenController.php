<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Service\ExamenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ExamenController extends AbstractController
{
    #[Route('/examen', name: 'app_examen')]
    public function index(): Response
    {
        return $this->render('examen/index.html.twig', [
            'controller_name' => 'ExamenController',
        ]);
    }

    #[Route('/examen/new', name: 'app_examen_new_form')]
    public function crearConFormulario(
        Request $request,
        ValidatorInterface $validator,
        ExamenService $examenService
    ): Response {

        if (!$this->getUser()) {
            $this->addFlash('error', 'Debes iniciar sesión para crear un examen.');
            return $this->redirectToRoute('app_login');
        }

        $examen = new Examen();

        if ($request->isMethod('POST')) {
            $materia = $request->request->get('materia');
            $nota = (float) $request->request->get('nota');
            $fecha = new \DateTime($request->request->get('fecha'));
            $examen->setMateria($materia);
            $examen->setNota($nota);
            $examen->setFecha($fecha);

            $errores = $validator->validate($examen);
            if (count($errores) > 0) {
                foreach ($errores as $error) {
                    $this->addFlash("warning", $error->getMessage());
                }
                return $this->render("examen/crear.html.twig", ["examen" => $examen]);
            } else {
                if ($examenService->crearExamen($materia, $nota, $fecha)) {
                    $this->addFlash("success", "Examen creado correctamente");
                    return $this->redirectToRoute("app_examen");
                } else {
                    $this->addFlash("error", "No se pudo crear el examen.");
                }
            }
        }

        return $this->render("examen/crear.html.twig", ["examen" => $examen]);
    }
}





