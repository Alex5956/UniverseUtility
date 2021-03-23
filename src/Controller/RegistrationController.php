<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UtilisateurAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param UtilisateurAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UtilisateurAuthenticator $authenticator): Response
    {

        /** @var User $user */
        $user = new User();
        /** @var User $user */
        $form = $this->createForm(RegistrationFormType::class, $user);
        try    {$form->handleRequest($request);}
        catch (\Exception $e){
            echo $e->getMessage();
        }

        if ($form->isSubmitted() && $form->isValid()) {
//            /** @var UploadedFile $uploadFile */
//            $uploadedFile = $form['file']->getData();
//            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/Fichiers';
            /** @var  UploadedFile $uploadFile */

            $uploadFile =$form->get('file')->getData();
            if($uploadFile===null) exit;
            $destination=$this->getParameter('files_directory');

            $originalFilename=pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename=Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadFile->guessExtension();

            //$fileName = md5(uniqid()).'.'.$file->guessClientExtension();
            try {
                $uploadFile->move(
                    $destination,
                    $newFilename
                // $this->getParameter('files_directory'),


                );
            }
            catch (\Exception $e){
                echo $e ;
            }

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            /** @var User $user */
            $user->setFile($newFilename);
            /** @var RegistrationController $this */
            $entityManager = $this->getDoctrine()->getManager();
            /** @var User $user */
            $entityManager->persist($user);

            $entityManager->flush();

            // do anything else you need here, like send an email


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


}
