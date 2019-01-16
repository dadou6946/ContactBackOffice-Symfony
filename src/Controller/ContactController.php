<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * AdminLessonController constructor.
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }


    /** Formulaire de contact
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(Request $request): Response
    {
        $message = new Message();
        $form = $this-> createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->om->persist($message);
            $this->om->flush();
            $this->addFlash('success','Votre message a bien été enregistré. Nous reviendrons prochainement vers vous!');
            return $this->redirectToRoute("contact");
        }
        
        return $this->render("contact/index.html.twig", [
                "message" => $message,
                "form" => $form->createView()
            ]);

    }
}

