<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [      
            'controller_name' => 'UserController',
        ]);
    }
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $roles = $request->request->get('roles');

        if (!$roles) {
            $roles = json_encode([]);
        }

        $user = new Utilisateur($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setRoles(($roles));
        $em->persist($user);
        $em->flush();   

        return new Response(sprintf('Utilisateur %s successfully created', $user->getUsername()));
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

}
