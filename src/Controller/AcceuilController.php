<?php

namespace App\Controller;


use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use Gedmo\Sluggable\Util\Urlizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Stripe\Stripe;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;


class AcceuilController extends AbstractController
{
    private $sessionMy ;

    /**
     * AcceuilController constructor
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)

    {
        $this->sessionMy=$session;
        $this->sessionMy->set('acheteurBoolean','false');
    }

    /**
     * @Route("/", name="acceuil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user= new User();

        /** @var User $user */
        $form2=$this->createForm(UserType::class,$user);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            /** @var UploadedFile $task */
            $task = $form2->get('file')->getData();
            $destination=$this->getParameter('files_directory');
            $originalFilename=pathinfo($task->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename=Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$task->guessExtension();

            //$fileName = md5(uniqid()).'.'.$file->guessClientExtension();
            $task->move(
                $destination,
                $newFilename
            // $this->getParameter('files_directory'),


            );


            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();
            Stripe::$accountId;
            return $this->redirectToRoute('acceuil',['task'=>$task]);
        }




        return $this->render('acceuil/index.html.twig', [
            'form2'=>$form2->createView(),
            'controller_name' => 'AcceuilController',

        ]);
    }
    /**
     * @Route("app_login_autocomplete", methods="GET", name="app_login_autocomplete")
     *
     */
    public function getUsersApi(UserRepository $userRepository, Request $request)
    {
        $users = $userRepository->findAllMatching($request->query->get('query'));

        return $this->json([
            'users' => $users
        ], 200, [], ['groups' => ['main']]);
    }

    /**
     * @Route ("/email")
     * @param MailerInterface $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendEMail(MailerInterface $mailer){
        $email= (new Email())
            ->from('alexandre.marillesse@gmail.com')
            ->to('alexandre.marillesse@gmail.com')
            ->subject('coucou')
            ->text('email envoyé')
            ->html("<p> See twig integrations for better HTML integration</p>");
        $mailer->send($email);
        return $this->redirectToRoute('acceuil');
    }

}
