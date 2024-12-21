<?php
namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface; 
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{
    private $commandeRepository;
    private $entityManager;

    public function __construct(CommandeRepository $commandeRepository, EntityManagerInterface $entityManager)
    {
        $this->commandeRepository = $commandeRepository;
        $this->entityManager = $entityManager;
    }

    

    #[Route('/commandes', name: 'admin_commande_list', methods: ['GET'])]
public function index(Request $request, CommandeRepository $commandeRepository, PaginatorInterface $paginator): Response
{
    // Récupérer les données à paginer
    $query = $commandeRepository->createQueryBuilder('c')->getQuery();

    // Paginer les données
    $commandes = $paginator->paginate(
        $query, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
        10 // Nombre d'éléments par page
    );

    return $this->render('commande/index.html.twig', [
        'commandes' => $commandes,
    ]);
}



    

    #[Route('/commandes/create', name: 'commande_create')]
    public function create(Request $request): Response
    {
        $commande = new Commande();// Initialisation d'une nouvelle commande
        $form = $this->createForm(CommandeType::class, $commande);//Utilise le formulaire défini dans CommandeType pour générer le formulaire associé à l'entité Commande
    
        $form->handleRequest($request);//Lit les données envoyées par l'utilisateur dans la requête HTTP ($request) et les associe à l'entité $commande
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($commande);//Prépare l'entité pour l'ajouter dans la base de données.Cela signifie que Doctrine connaît maintenant cet objet et le suivra pour toute modification
            $this->entityManager->flush();//Applique les modifications dans la base de données.enregiste les données et insère une nouvelle ligne pour l'entité Commande dans la table correspondante.

    
            return $this->redirectToRoute('admin_commande_list');
        }
    
        return $this->render('commande/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commandes/{id}/edit', name: 'commande_edit')]
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
    
            return $this->redirectToRoute('admin_commande_list');
        }
    
        return $this->render('commande/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commandes/{id}/delete', name: 'commande_delete')]
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($commande);
            $this->entityManager->flush();
        }
    
        return $this->redirectToRoute('admin_commande_list');
    }
}
