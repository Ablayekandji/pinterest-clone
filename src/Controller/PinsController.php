<?php

namespace App\Controller;

use App\Entity\Pins;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class PinsController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        // $pin = new Pins();
        // $pin->setTitle("niania 1");
        // $pin->setDescription("commentaire de niania 1");
        // $em = $this->getDoctrine()->getManager(); j'a fai une injection de dependance au niveau du constructeur
        // $this->em->persist($pin);
        // $this->em->flush();
        // dd($pin);
        // $pin->save();
        $repo = $this->em->getRepository(Pins::class);
        $pin = $repo->findAll();
        return $this->render('pins/index.html.twig', ["liste" => $pin]);
    }

    /**
     * @Route("/pins/create", name="app_pins_create",methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {

        $form = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('submit', SubmitType::class, ['label' => 'creer un Pin'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            # code...
            $data = $form->getData();
            $pin = new Pins;
            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);
            $this->em->persist($pin);
            $this->em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', ['monFormulaire' => $form->createView()]);
    }
}