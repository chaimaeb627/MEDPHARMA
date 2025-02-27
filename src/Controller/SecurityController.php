<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(Request $request, EntityManagerInterface $em): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_medicament_list'); // Redirige l'utilisateur s'il est déjà connecté
        }

        $user = new User(); // Vous pouvez avoir un objet User personnalisé ici
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'utilisateur dans la base de données
            $em->persist($user);
            $em->flush();

            // Vous pouvez ensuite rediriger l'utilisateur vers une page de succès ou un tableau de bord
            return $this->redirectToRoute('admin_medicament_list');
        }

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

