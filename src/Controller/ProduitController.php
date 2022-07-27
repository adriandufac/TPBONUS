<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{

    /**
     * @Route("/ajoutProduit",name="produit_add")
     */
    public function add(Request $request,EntityManagerInterface $entityManager){

        $produit = new Produit();
        //creation du formulaire
        $produitForm = $this->createForm(ProduitType::class,$produit);

        $produitForm->handleRequest($request);
        //si on submit le formulaire
        if($produitForm->isSubmitted()){
            //ajout de la produit en base
            $produit->setDateAjout(new \DateTime('@'.strtotime('now')));
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('success', 'produit ajouté!');
            //on affiche la liste des produits
            return $this->redirectToRoute('main_home');
        }

        //on envoit le formulaire a la page d'ajout de category
        return $this->render('produit/ajoutproduit.html.twig',['produitForm' =>$produitForm->createView()]);

    }

    /**
     * @Route("/produitDetails/{id}", name="produit_details")
     */
    public function details(int $id,ProduitRepository $wishRepository): Response
    {
        $produit = $wishRepository->find($id);
        return $this->render('produit/details.html.twig',["produit" => $produit]);
    }

    /**
     * @Route("/produitDelete/{id}", name="produit_delete")
     */

    public function delete(int $id,ProduitRepository $wishRepository,EntityManagerInterface $entityManager): Response
    {
         $entityManager->remove($wishRepository->find($id));
         $entityManager->flush();
         return $this->redirectToRoute('main_home');
    }

}