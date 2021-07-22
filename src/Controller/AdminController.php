<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Entity\User;
use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepo): Response
    {

        $users = $userRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users
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

    /**
     * @Route("/admin/del/user/{id}", name="adminDelUser")
     */
    public function delUser(User $user, EntityManagerInterface $manager): Response
    {

        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/del/todo/{id}", name="adminDelTodo")
     */
    public function delTodo(Todo $todo): Response
    {
        dd($todo);

        return $this->render('admin/show.html.twig', [
            'user' => $user
        ]);
    }
}
