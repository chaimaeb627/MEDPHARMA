<?php
namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface; 
use App\Entity\Medicament;
use App\Form\MedicamentType;
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
        $this->mediacementRepository = $medicamentRepository;
        $this->entityManager = $entityManager;
    }

    

    #[Route('/medicament', name: 'admin_medicament_list', methods: ['GET'])]
public function index(Request $request, MedicamentRepository $medicamentRepository, PaginatorInterface $paginator): Response
{
    // Récupérer les données à paginer
    $query = $medicamentRepository->createQueryBuilder('c')->getQuery();

    // Paginer les données
    $medicaments = $paginator->paginate(
        $query, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
        10 // Nombre d'éléments par page
    );

    return $this->render('med/index.html.twig', [
        'medicaments' => $medicaments,
    ]);
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
}
