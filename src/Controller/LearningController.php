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

class LearningController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    #[Route('/', name: 'home-page')]
    public function showMyName(Request $request): Response
    {
        // // creates a task object and initializes some data for this example
        $name = new Name();

        $form = $this->createFormBuilder($name)
            ->add('name', TextType::class, array('attr' => array('class' => 'border-2 ml-2')))
            ->add('save', SubmitType::class, ['label' => 'Save Name'])
            ->setAction($this->generateUrl('change-name'))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($request->request->get('form')['name'])) {
                $this->session->set('name', $request->request->get('form')['name']);
            }
        }
        if ($this->session->get('name') != null) {
            $name = $this->session->get('name');
        } else {
            $name = "Unknown";
        }
        return $this->render('learning/index.html.twig', [
            'name' => $name,
            'page' => "change-page",
            'form' => $form->createView(),
            'title' => "Home"
        ]);
    }

    #[Route('/change-name', name: 'change-name', methods: ['POST'])]
    public function changeMyName(Request $request): Response
    {
        // $name = new Name();
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Change Name'])
            ->setAction($this->generateUrl('home-page'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($request->request->get('form')['name'])) {
                $this->session->set('name', $request->request->get('form')['name']);
                $name = $this->session->get('name');
                return $this->render('learning/index.html.twig', [
                    'name' => $name,
                    'page' => 'home',
                    'form' => $form->createView(),
                    'title' => 'Change Name'
                ]);
            }
        }
    }


    #[Route('/about-becode', name: 'about-me')]
    public function aboutMe(): Response
    {
        if ($this->session->get('name') != null) {
            $name = $this->session->get('name');
            return $this->render('learning/about-me.html.twig', [
                'title' => 'About me',
                'name' => $name,
            ]);
        } else {
            // return $this->redirectToRoute('home-page');
            return $this->forward('App\Controller\LearningController::showMyName');
        }
    }
}
