<?php

namespace App\Controller;

use App\Entity\Capitalizer;
use App\Entity\Transform;
use App\Entity\DashConverter;
use App\Entity\MonoLogger;
use App\Entity\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CapitalizerController extends AbstractController
{
    private $capitalizer;
    private $monoLogger;

    public function __construct(Transform $capitalizer, MonoLogger $monoLogger)
    {
        $this->capitalizer = $capitalizer;
        $this->monoLogger = $monoLogger;
    }

    #[Route('/capitalizer', name: 'capitalizer')]
    public function index(): Response
    {
        // $name = new Name();

        $form = $this->createFormBuilder("No Name")
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Save Name'])
                ->setAction($this->generateUrl('change-name'))
            ->getForm();

        return $this->render('capitalizer/index.html.twig', [
            // 'value' => $this->setVariable("kenyer"),
            'form' => $form->createView()
        ]);
    }
}
