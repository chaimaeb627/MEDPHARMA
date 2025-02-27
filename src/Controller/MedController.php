<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface; 
use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Form\RechercheProduitType;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MedController extends AbstractController
{
    private $medicamentRepository;
    private $entityManager;

    public function __construct(MedicamentRepository $medicamentRepository, EntityManagerInterface $entityManager)
    {
        $this->medicamentRepository = $medicamentRepository;
        $this->entityManager = $entityManager;
    }
    


    #[Route('/medicament', name: 'admin_medicament_list', methods: ['GET', 'POST'])]
    public function index(Request $request, PaginatorInterface $paginator, MedicamentRepository $medicamentRepository): Response
    {
        // Création et gestion du formulaire de recherche
        $form = $this->createForm(RechercheProduitType::class);
        $form->handleRequest($request);

        // Construction de la requête pour la recherche
        $queryBuilder = $medicamentRepository->createQueryBuilder('m');

        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('nom')->getData();
            if ($searchTerm) {
                $queryBuilder->andWhere('m.nom LIKE :searchTerm')
                    ->setParameter('searchTerm', '%' . $searchTerm . '%');
            }
        }

        $query = $queryBuilder->getQuery();
        $medicaments = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        // Calcul des statistiques des produits
        $totalProduits = $medicamentRepository->count([]);
        $totalStock = $medicamentRepository->createQueryBuilder('m')
            ->select('SUM(m.quantiteenstock)')
            ->getQuery()
            ->getSingleScalarResult();
        $produitsRupture = $medicamentRepository->count(['quantiteenstock' => 0]);
        $produitsExpireBientot = $medicamentRepository->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.datelimite <= :date')
            ->setParameter('date', new \DateTime('+1 month'))
            ->getQuery()
            ->getSingleScalarResult();

        // Exemple de statistiques des ventes
        $medicamentsVendus = [50, 120, 90, 150, 200, 180, 220]; // Quantités des médicaments vendus
        $tendance = [40, 100, 80, 140, 180, 170, 210]; // Données de tendance

        // Rendu de la vue avec les données
        return $this->render('med/index.html.twig', [
            'medicaments' => $medicaments,
            'form' => $form->createView(),
            'totalProduits' => $totalProduits,
            'totalStock' => $totalStock,
            'produitsRupture' => $produitsRupture,
            'produitsExpireBientot' => $produitsExpireBientot,
            'medicamentsVendus' => $medicamentsVendus,
            'tendance' => $tendance,
        ]);
    }
    #[Route('/profile', name: 'user_profile')]
public function profile(): Response
{
    return $this->render('produit/profile.html.twig');
}



    #[Route('/medicament/create', name: 'medicament_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($medicament);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('admin_medicament_list');
        }
    
        return $this->render('med/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/medicament/{id}/edit', name: 'medicament_edit')]
    public function edit(Request $request, Medicament $medicament): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
    
            return $this->redirectToRoute('admin_medicament_list');
        }
    
        return $this->render('med/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/medicament/{id}/delete', name: 'medicament_delete')]
    public function delete(Request $request, Medicament $medicament): Response
    {
        if ($this->isCsrfTokenValid('delete' . $medicament->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($medicament);
            $this->entityManager->flush();
        }
    
        return $this->redirectToRoute('admin_medicament_list');
    }

    #[Route('/medicament/{id}/view', name: 'medicament_view')]
    public function viewMedicament(int $id, MedicamentRepository $medicamentRepository): Response
    {
        $medicament = $medicamentRepository->find($id);

        if (!$medicament) {
            throw $this->createNotFoundException('Le médicament demandé n\'existe pas.');
        }

        return $this->render('med/view.html.twig', [
            'medicament' => $medicament,
        ]);
    }
}
