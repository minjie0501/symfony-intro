<?php

namespace App\Controller;

use App\Entity\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;

class LearningController extends AbstractController
{

    // public function __construct()
    // {
    //     // create a log channel
    //     $log = new Logger('name');
    //     $log->pushHandler(new StreamHandler('./log.info', Logger::INFO));
    
    //     // add records to the log
    //     $log->info('Bar');
    // }

    // TODO: add form builder for the other form

    #[Route('/', name: 'home-page')]
    public function showMyName(SessionInterface $session): Response
    {
        // // creates a task object and initializes some data for this example
        $name = new Name();

        $form = $this->createFormBuilder($name)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Save Name'])
                ->setAction($this->generateUrl('change-name'))
            ->getForm();

        if(isset($_POST['name'])){
            $session->set('name', $_POST['name']);
        }
        if ($session->get('name') != null) {
            $name = $session->get('name');
        } else{
            $name = "Unknown";
        }
        return $this->render('learning/index.html.twig', [
            'name' => $name,
            'page' => "change-page",
            'form' => $form->createView()
        ]);
    }

    #[Route('/change-name', name: 'change-name', methods: ['POST'])]
    public function changeMyName(SessionInterface $session, Request $request): Response
    {
        if (isset($request->request->get('form')['name'])) {
            $session->set('name', $request->request->get('form')['name']);
            $name = $session->get('name');
            return $this->render('learning/index.html.twig', [
                'name' => $name,
                'page' => 'home'
            ]);
        }
    }

    #[Route('/about-becode', name: 'about-me')]
    public function aboutMe(SessionInterface $session): Response
    {
        if ($session->get('name') != null) {
            $name = $session->get('name');
            return $this->render('learning/about-me.html.twig', [
                'title' => 'About me',
                'name' => $name
            ]);
        } else {
            return $this->redirectToRoute('home-page');
        }
    }
}
