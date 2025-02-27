<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commmande;
use App\Form\ProduitType;
use App\Form\AchatType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitController extends AbstractController
{
    #[Route('/produits/cosmetiques', name: 'produits_cosmetiques', methods: ['GET'])]
    public function cosmetiques(ProduitRepository $produitRepository, EntityManagerInterface $em): Response
    {
        // Vérifier si la table produit est vide et insérer des produits par défaut
        if ($produitRepository->count([]) === 0) {
            $produits = [
                ['nom' => 'Crème Hydratante', 'desc' => 'Crème pour peau sèche.', 'prix' => 150, 'promo' => 120, 'image' => 'mayb.png', 'categorie' => 'cosmetique'],
                ['nom' => 'Shampooing Bio', 'desc' => 'Shampooing naturel.', 'prix' => 90, 'promo' => null, 'image' => 'shampooing.png', 'categorie' => 'cosmetique'],
                ['nom' => 'Rouge à Lèvres', 'desc' => 'Couleur intense.', 'prix' => 80, 'promo' => 70, 'image' => 'rouge_levres.png', 'categorie' => 'cosmetique'],
                ['nom' => 'BEAUTY OF JOSEON - HANBANG SERUM DISCOVERY KIT 10ML', 'desc' => 'Réference 8809738315897', 'prix' => 380, 'promo' => 320, 'image' => 'serum.png', 'categorie' => 'cosmetique'],
                ['nom' => 'PERFECTIL - COMPLEMENT 30 JOURS', 'desc' => 'Réference 5021265246090', 'prix' => 159, 'promo' => 135,15, 'image' => 'perfe.png', 'categorie' => 'cosmetique'],
            ];

            foreach ($produits as $data) {
                $produit = new Produit();
                $produit->setNom($data['nom']);
                $produit->setDescription($data['desc']);
                $produit->setPrix($data['prix']);
                $produit->setPrixPromo($data['promo'] !== null ? (string) $data['promo'] : '0');

                $produit->setImage(trim($data['image']));
                $produit->setCategorie($data['categorie']);
                $em->persist($produit);
            }

            $em->flush();
        }

        // Récupérer les produits de la catégorie "cosmetique"
        $produits = $produitRepository->findBy(['categorie' => 'cosmetique']);
        
        return $this->render('produit/cosmetique.html.twig', [
            'produits' => $produits
        ]);
    }

    #[Route('/produit/ajouter', name: 'produit_ajouter', methods: ['POST', 'GET'])]
public function ajouterProduit(Request $request, EntityManagerInterface $entityManager): Response
{
    $produit = new Produit();
    $form = $this->createForm(ProduitType::class, $produit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Définir la catégorie automatiquement
        $produit->setCategorie('cosmetique');

        // Gestion de l'upload d'image
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            try {
                $imageFile->move($this->getParameter('images_directory'), $newFilename);
                $produit->setImage($newFilename);
            } catch (FileException $e) {
                return new Response("Erreur lors de l'upload de l'image", 500);
            }
        }

        // Sauvegarde du produit
        $entityManager->persist($produit);
        $entityManager->flush();

        // Rediriger vers la liste des produits cosmétiques
        return $this->redirectToRoute('produits_cosmetiques');
    }

    return $this->render('produit/create.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/achat', name: 'app_achat')]
    public function achat(Request $request): Response
    {
        // Création du formulaire
        $form = $this->createForm(AchatType::class);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les données si nécessaire (ajout en base de données, email, etc.)
            
            // Ajout d'un message flash pour confirmer l'achat
            $this->addFlash('success', 'Votre achat a été enregistré avec succès !');

            // Redirection vers la même page pour éviter la double soumission du formulaire
            return $this->redirectToRoute('app_achat');
        }

        // Rendu de la page avec le formulaire
        return $this->render('produit/achat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
