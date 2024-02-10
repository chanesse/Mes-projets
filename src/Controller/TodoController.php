<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/todo")]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        // Afficher le tableau de todo
        //sinon je l'initialise puis j'affiche 
        if (!$session->has(name: 'todos')) {
            $todos = [
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash(type: 'info', message: "la liste des todos viens d'etre initialisée ");
        }
        // si j'ai le tableau de todo dans la session je ne fait que l'afficher
        return $this->render('todo/index.html.twig');
    }
    #[Route(
        '/add/{name?test}/{content?test}', 
        name: 'todo.add',
    )]
    public function addTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //vérifier si j'ai un tableau de todo dans la session 
        if ($session->has(name: 'todos')) {
            // si oui
            // vérifier si ya un déja un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash(type: 'error', message: "Le todos d'id $name exite déja dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succes
                $todos[$name] = $content;
                $this->addFlash(type: 'success', message: "le todo d'id $name a été ajouté avec succes");
                $session->set('todos', $todos);
            }
        } else {
            //si non 
            //afficher une erreur et rediger vers le controller index
            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée ");
        }
        return $this->redirectToRoute('app_todo');
    }
    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse
    {
        $session = $request->getSession();
        //vérifier si j'ai un tableau de todo dans la session 
        if ($session->has(name: 'todos')) {
            // si oui
            // vérifier si ya un déja un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (!isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash(type: 'error', message: "Le todos d'id $name n'exite pas dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succes
                $todos[$name] = $content;
                $this->addFlash(type: 'success', message: "le todo d'id $name a été modifié avec succes");
                $session->set('todos', $todos);
            }
        } else {
            //si non 
            //afficher une erreur et rediger vers le controller index
            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée ");
        }
        return $this->redirectToRoute('app_todo');
    }
    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse
    {
        $session = $request->getSession();
        //vérifier si j'ai un tableau de todo dans la session 
        if ($session->has(name: 'todos')) {
            // si oui
            // vérifier si ya un déja un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (!isset($todos[$name])) {
                // si oui afficher erreur
                $this->addFlash(type: 'error', message: "Le todos d'id $name n'exite pas dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succes
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "le todo d'id $name a été supprimé avec succes");
            }
        } else {
            //si non 
            //afficher une erreur et rediger vers le controller index
            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée ");
        }
        return $this->redirectToRoute('app_todo');
    }
    #[Route('/reset', name: 'todo.reset')]
    public function restTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();
        $session->remove(name:'todos');
       
        return $this->redirectToRoute('app_todo');
    }
}
