<?php

namespace App\Controller;

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
     * @Route("/admin/show/{}", name="adminShow")
     */
    public function show(UserRepository $userRepo, TodoRepository $todoRepo, $id = null): Response
    {




        return $this->render('admin/index.html.twig', [
            'users' => $users,
            'todos' => $todos
        ]);
    }
}
