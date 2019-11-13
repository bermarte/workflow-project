<?php

namespace App\Controller;

use App\Form\SaveUserNameType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/index", name="main")
     */
    public function index()
    {
       // $manager1 = $this->get('security.token_storage')->getToken()->getUser();

       // $manag = $this->getDoctrine()->getRepository(User::class)
          //  ->findOneBy(['id' => $manager1->getId()]);

     /*   $manager1 = new User();
        $manager1->setEmail('John@gmail.com');
        $manager1->setName('John');
        $manager1->setPassword('0123456789***');
        $manager1->setIsManager('true');


        $en = $this->getDoctrine()->getManager();
        $en->persist($manager1);
        $en->flush(); */

      /*  $agent1 = new User();
        $agent1->setEmail('sicco2@gmail.com');
        $agent1->setName('sicco2');
        $agent1->setPassword('0123456789***');
        $agent1->setIsAgent('true');


        $en = $this->getDoctrine()->getManager();
        $en->persist($agent1);
        $en->flush(); */



        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
   //other routes

    /**
     * @Route("/user_name", name="user_name")
     */
    public function write_name(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $current_user = $this->getDoctrine()->getRepository(User::class)
            ->findOneBy(['id' => $user->getId()]);
        //pass email in the form
        /*
        $current_user->getEmail();
        $current_user->setName("aldo");
        */

        $form = $this->createForm(SaveUserNameType::class, $current_user, [
            'action' => $this->generateUrl('user_name')

        ]);
        //handle request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //var_dump($current_user); die();
            //save new password
            $current_user->setPassword(
                $passwordEncoder->encodePassword(
                    $current_user,
                    $form->get('plainPassword')->getData()
                )
            );

            //saving to db

            $en = $this->getDoctrine()->getManager();
            $en->persist($user);
            $en->flush();

            $this->get('session')->getFlashBag()->add('notice', array('type' => 'success', 'title' => 'Success!', 'message' => 'user data updated'));
            return $this->redirectToRoute("main");
        }


        return $this->render('form-data/form-data.html.twig', [
            'form_user_name' => $form->createView()
        ]);
    }
}
