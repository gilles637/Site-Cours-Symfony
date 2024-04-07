<?php

namespace App\Controller;

use App\Entity\Lecon;
use App\Form\LeconType;
use App\Repository\LeconRepository;
use cebe\markdown\Markdown;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lecon')]
class LeconController extends AbstractController
{
    #[Route('/', name: 'app_lecon_index', methods: ['GET'])]
    public function index(Request $request, LeconRepository $leconRepository,
                          Markdown $markdown, PaginatorInterface $paginator): Response
    {

        $lecons = $leconRepository->findBy([],['createdAt'=>'DESC']);
        $parsedLecons = [];

        foreach ($lecons as $lecon) {

            $parseLecon = $lecon;
            $parseLecon -> setDescription($markdown -> parse($lecon -> getDescription()));
            $parsedLecons[] = $parseLecon;

        }

        $pageLecons = $paginator->paginate(
            $parsedLecons,
            $request->query->getInt('page', 1)
        );

        return $this->render('lecon/index.html.twig', [
            'lecons' => $pageLecons,
        ]);

    }

    #[Route('/meslecons', name: 'app_lecon_meslecons', methods: ['GET'])]
    public function indexMesLecons(Request $request, LeconRepository $leconRepository,
                          Markdown $markdown, PaginatorInterface $paginator): Response
    {

        $lecons = $leconRepository->findByEleve($this->getUser());
        $parsedLecons = [];

        foreach ($lecons as $lecon) {

            $parseLecon = $lecon;
            $parseLecon -> setDescription($markdown -> parse($lecon -> getDescription()));
            $parsedLecons[] = $parseLecon;

        }

        $pageLecons = $paginator->paginate(
            $parsedLecons,
            $request->query->getInt('page', 1)
        );

        return $this->render('lecon/mes_lecons.html.twig', [
            'lecons' => $pageLecons,
        ]);

    }

    #[Route('/new', name: 'app_lecon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lecon = new Lecon();
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lecon->setProfesseur($this->getUser());
            $entityManager->persist($lecon);
            $entityManager->flush();

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lecon/new.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecon_show', methods: ['GET'])]
    public function show(Lecon $lecon): Response
    {
        return $this->render('lecon/show.html.twig', [
            'lecon' => $lecon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lecon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lecon/edit.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecon_delete', methods: ['POST'])]
    public function delete(Request $request, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lecon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lecon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/add/{id}', name: 'app_lecon_add')]
    public function add(int $id, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        $this->getUser()->addMesLecon($lecon);
        $lecon->addElefe($this->getUser());
        $entityManager->flush();
        return $this->redirectToRoute('app_lecon_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/remove/{id}', name: 'app_lecon_remove')]
    public function remove(int $id, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        $this->getUser()->removeMesLecon($lecon);
        $lecon->removeElefe($this->getUser());
        $entityManager->flush();
        return $this->redirectToRoute('app_lecon_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
    }
}
