<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Form\DrawType;
use App\Repository\DrawRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/draw')]
class DrawController extends AbstractController
{
    #[Route('/', name: 'app_draw_index', methods: ['GET'])]
    public function index(Request $request, DrawRepository $drawRepository, PaginatorInterface $paginator): Response
    {
        $query = $drawRepository->getAllQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('draw/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_draw_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DrawRepository $drawRepository): Response
    {
        $draw = new Draw();
        $form = $this->createForm(DrawType::class, $draw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $drawRepository->save($draw, true);

            return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('draw/new.html.twig', [
            'draw' => $draw,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_draw_show', methods: ['GET'])]
    public function show(Draw $draw): Response
    {
        return $this->render('draw/show.html.twig', [
            'draw' => $draw,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_draw_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Draw $draw, DrawRepository $drawRepository): Response
    {
        $form = $this->createForm(DrawType::class, $draw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $drawRepository->save($draw, true);

            return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('draw/edit.html.twig', [
            'draw' => $draw,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_draw_delete', methods: ['POST'])]
    public function delete(Request $request, Draw $draw, DrawRepository $drawRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$draw->getId(), $request->request->get('_token'))) {
            $drawRepository->remove($draw, true);
        }

        return $this->redirectToRoute('app_draw_index', [], Response::HTTP_SEE_OTHER);
    }
}
