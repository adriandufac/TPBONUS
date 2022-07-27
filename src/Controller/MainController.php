<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/",name="main_home")
     */
    public function home(ProduitRepository $produitRepository){
        $produits = $produitRepository->findAll();
        return $this->render('main/home.html.twig',["produits"=>$produits]);
    }

    /**
     * @Route("/ajoutProduit",name="main_add")
     */
    public function test(Request $request,EntityManagerInterface $entityManager){

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
        return $this->render('main/ajout.html.twig',['produitForm' =>$produitForm->createView()]);

    }

}