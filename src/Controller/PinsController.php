<?php

namespace App\Controller;

use App\Entity\Pins;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="")
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
}
