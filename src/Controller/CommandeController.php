<?php
namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface; 
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Form\RechercheCommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController

{
    private $commandeRepository;//Injecté pour accéder aux données des commandes depuis la base via Doctrine.
    private $entityManager;//Gestionnaire d'entités Doctrine utilisé pour les opérations de persistance, mise à jour et suppression dans la base de donnée

    public function __construct(CommandeRepository $commandeRepository, EntityManagerInterface $entityManager)
    {
        $this->commandeRepository = $commandeRepository;
        $this->entityManager = $entityManager;
    }

    

    #[Route('/commandes', name: 'admin_commande_list', methods: ['GET', 'POST'])]
public function index(Request $request, CommandeRepository $commandeRepository, PaginatorInterface $paginator): Response
{
    // Créer le formulaire de recherche
    $form = $this->createForm(RechercheCommandeType::class);
    $form->handleRequest($request);

    // Initialiser la requête de recherche des commandes
    $queryBuilder = $commandeRepository->createQueryBuilder('c');

    // Appliquer les filtres
    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        if ($data['datecommande']) {
            $queryBuilder
                ->andWhere('c.datecommande = :datecommande')
                ->setParameter('datecommande', $data['datecommande']);
        }
    }

    // Récupérer les données à paginer
    $query = $queryBuilder->getQuery();

    // Paginer les données
    $commandes = $paginator->paginate(
        $query, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
        10 // Nombre d'éléments par page
    );

    return $this->render('commande/index.html.twig', [
        'commandes' => $commandes,
        'form' => $form->createView(), // Ajouter le formulaire de recherche à la vue
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
    public function edit(Request $request, Commande $commandes): Response
    {
        $form = $this->createForm(CommandeType::class, $commandes);//Génération d'un formulaire pour modifier l'entité existante.
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();//Validation et mise à jour de l'entité dans la base via flush()
    
            return $this->redirectToRoute('admin_commande_list');//Redirection vers la liste des commandes après enregistrement.
        }
    
        return $this->render('commande/edit.html.twig', [
            'form' => $form->createView(),// Transforme l'objet form en vue utilisable dans Twig
        ]);
    }

    #[Route('/commande/{id}/delete', name: 'commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('admin_commande_list');
    }
    #[Route('/commande/{id}/view', name: 'commande_view')]
    public function viewCommande(int $id, CommandeRepository $commandeRepository): Response
    {
        $commande = $commandeRepository->find($id);
    
        if (!$commande) {
            throw $this->createNotFoundException('La commande demandée n\'existe pas.');
        }
    
        return $this->render('commande/view.html.twig', [
            'commande' => $commande,
        ]);
    }
    
    
}
