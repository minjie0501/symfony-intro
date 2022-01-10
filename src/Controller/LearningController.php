<?php

namespace App\Controller;

use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LearningController extends AbstractController
{



    #[Route('/', name: 'home-page')]
    public function showMyName(SessionInterface $session): Response
    {
        if ($session->get('name') != null) {
            $name = $session->get('name');
        }else{
            $name = "Unknown";
        }
        return $this->render('learning/index.html.twig', [
            'name' =>$name,
        ]);
    }

    #[Route('/change-name', name: 'change-name', methods: ['POST'])]
    public function changeMyName(SessionInterface $session): Response
    {
        if(isset($_POST['name'])){
            $session->set('name', $_POST['name']);
            return $this->redirectToRoute('home-page');
        }
    }

    // #[Route('/learning', name: 'learning')]
    // public function index(): Response
    // {
    //     return $this->render('learning/index.html.twig', [
    //         'controller_name' => 'LearningController',
    //     ]);
    // }



    #[Route('/about-me', name: 'about-me')]
    public function aboutMe(): Response
    {
        return new Response(
            '<html><body>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas molestiae labore laudantium, quam necessitatibus inventore ipsa vero libero repellendus aliquid praesentium nemo. Facilis, hic non.
            </body></html>'
        );
    }
}
