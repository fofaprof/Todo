<?php

namespace App\Controller;

use App\Form\TodoType;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Todo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/create", name="create-todo")
     */
    public function create(Request $request)
    {
    	$entityManager = $this->getDoctrine()->getManager();

    	$form = $this -> createForm(TodoType::class);

    	$form -> handleRequest($request);
    	// perevirka chy zasabmitena i chy validna
    	if ($form -> isSubmitted() && $form -> isValid()) {
    		$data = $form -> getData();

    		$todo = new Todo();
    		$todo -> setName($data -> getName());
    		$todo -> setCategory($data -> getCategory());
    		$todo -> setDescription($data -> getDescription());
    		$todo -> setDueDate($data -> getDueDate());
    		$todo -> setCreateDate($data -> getCreateDate());

    		$entityManager -> persist($todo); // pidgotovlue dani
    		$entityManager -> flush(); // vidpravliae v bazu danyh

    		return $this -> redirectToRoute('index-todo'); // pislia zapovnennia i nadislannia danyh perekydae na inshu storinku <index-todo>
    	}

        return $this->render('todo/create.html.twig', ['todo_form' => $form->createView()
    ]);
    }

    /**
     * @Route("/", name="index-todo")
     */
    public function index() // zadaemo kuda perekliuchytsia storinka
    {
    	return $this -> render ('todo/index.html.twig');
    }
}
