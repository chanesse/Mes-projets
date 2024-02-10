<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar) {
        return new Response(content: "
        <html><body>$maVar</body></html>
        ");
    }
    #[Route('/template', name: 'template')]
    public function template() {
        return $this->render('template.html.twig');
    }

   

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        // chercher au niveau de la base de donnée les users
        return $this->render('first/index.html.twig', [
            'name' => 'ouguenoune',
            'firstname' => 'chanesse'
        ]) ;
    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' => $firstname,
            'path' => 'tim.jpg'
        ]);
       
    }
    #[Route(
        'multi/{entier1<\d+>}/{entier2<\d+>}',
        name: 'mutiplication',
    )]
    public function multiplication($entier1, $entier2) {
        $resultat = $entier1 * $entier2;
        return new Response(content:"<h1>$resultat</h1>");
    }

}
