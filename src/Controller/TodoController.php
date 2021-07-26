<?php

namespace App\Controller;

use App\Entity\Check;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/{_locale}")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     * @Route("/todo/order/{sort}/{order}", name="todo/")
     */
    public function index(UserInterface $user,TodoRepository $todoRepo,$sort = null, $order = null, PaginatorInterface $paginator, Request $request): Response
    {

        $todos = $user->getTodos();

        if($sort === "createdAt" && $order === "DESC"){
            $todos = $todoRepo->findByUserSortedByMostRecent($user);
        }
        if($sort === "createdAt" && $order === "ASC"){
            $todos =$todoRepo->findByUserSortedByLessRecent($user);
        }
        if($sort === "dueDate" && $order === "DESC"){
            $todos = $todoRepo->findByUserDueDateByMostRecent($user);
        }
        if($sort === "dueDate" && $order === "ASC"){
            $todos =$todoRepo->findByUserDueDateByLessRecent($user);
        }else{
            $todos = $todoRepo->findByUserSortedByMostRecent($user);
        }

        $todos = $paginator->paginate(
            $todos, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );


        return $this->render('todo/index.html.twig', [
            'todos' => $todos
        ]);
    }

    /**
     * @Route("/todo/check/{id}", name="check")
     */
    public function check(Todo $todo, EntityManagerInterface $manager, UserInterface $user): Response
    {

        $totoCheck = count($user->getChecks());
        if(!$todo->getChecked()){

            $check = new Check();
            $check->setTodo($todo);
            $check->setUser($todo->getUser());

            $manager->persist($check);
            $result = "checked";
            $totoCheck = $totoCheck +1;
        }else {
            $manager->remove($todo->getChecked());
            $result = "unchecked";
            $totoCheck = $totoCheck -1;
        }


        $manager->flush();
        $data = ['message' => "$result",
                 'TotoCheck' => "$totoCheck"];
        return $this->json($data, 200);

    }



    /**
     * @Route("/todo/json/", name="json")
     */
    public function msgJson(): Response
    {

        $tab = [
            "title" => "Je suis un titre",
            "description" => "Je suis une description"
        ];

        return $this->json($tab, 200);

    }
}
