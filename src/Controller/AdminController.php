<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findAll();

        $pageUsers = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1)
        );

        return $this->render('admin/index.html.twig', [
            'users' => $pageUsers,
        ]);
    }

    #[Route('/role/{role}', name: 'app_admin_role', methods: ['GET'])]
    public function indexRole(Request $request, string $role, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $users = $userRepository->findByRole($role);

        $pageUsers = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1)
        );

        return $this->render('admin/index.html.twig', [
            'users' => $pageUsers,
        ]);
    }

    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_PROFESSEUR']);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/give/{id}', name: 'app_admin_give')]
    public function add(int $id, User $user, EntityManagerInterface $entityManager): Response
    {
        $roles = $user->getRoles();
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
    }

    #[Route('/revoke/{id}', name: 'app_admin_revoke')]
    public function remove(int $id, User $user, EntityManagerInterface $entityManager): Response
    {
        $roles = $user->getRoles();
        $key = array_search('ROLE_ADMIN', $roles);
        unset($roles[$key]);
        $user->setRoles(array_values($roles));
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_show', ['id'=>$id], Response::HTTP_SEE_OTHER);
    }
}
