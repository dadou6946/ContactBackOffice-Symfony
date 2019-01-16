<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminMessageController extends AbstractController
{
    /**
     * @var MessageRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(MessageRepository $repository, ObjectManager $om)
    {
        $this->repository = $repository;
        $this->om = $om;
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index(): Response
    {
        $messages = $this->repository->findAll();
        return $this->render("admin/message/index.html.twig", [
            "messages" => $messages
        ]);

    }

    /** Traitement de message
     * @Route("admin/message/{id}", name="admin.message.detail", methods="GET")
     * @param Message $message
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Message $message)
    {
        return $this->render("admin/message/detail.html.twig", [
            "message" => $message
        ]);

    }

    /**
     * @Route("admin/edit/{id}", name="admin.message.edit", methods="GET")
     * @param Message $message
     * @return Response
     */
    public function edit(Message $message)
    {
        $message->setState(!$message->getState());
        $this->om->persist($message);
        $this->om->flush();

        if($message->getState() == 1) $traitement = " a été traité avec succès!";
        else $traitement = " a été rétabli en attente de traitement!";

        $this->addFlash('success','Le message n°'.$message->getId().$traitement);

        return $this->redirectToRoute('admin.message.detail', [
            'id' => $message->getId(),
        ], 301);

    }

}