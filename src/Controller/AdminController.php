<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
public function dashboard(): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN'); // Accès limité aux administrateurs

    return $this->render('commande/index.html.twig', [
        'message' => 'Bienvenue dans l’espace admin !',
    ]);
}

}
