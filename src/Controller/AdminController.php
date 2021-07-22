<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepo, TodoRepository $todoRepo): Response
    {

        $users = $userRepo->findAll();
        $todos = $todoRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'todos' => $todos
        ]);
    }

    /**
     * @Route("/admin/show/{id}", name="adminShow")
     */
    public function show(User $user, TodoRepository $todoRepo): Response
    {

        $todos = $user->getTodos();

        $todos = $todoRepo->findByUserSortedByMostRecent($user);

        return $this->render('admin/show.html.twig', [
            'user' => $user,
            'todos' => $todos
        ]);
    }
}
