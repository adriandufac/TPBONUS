<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categories",name="Categorie_list")
     */
    public function list(){
        return $this->render('categorie/list.html.twig');
    }

    /**
     * @Route("/ajoutCategorie",name="Categorie_ajout")
     */
    public function ajout(Request $request,EntityManagerInterface $entityManager){

        $category = new Category();
        //creation du formulaire
        $categoryForm = $this->createForm(CategoryType::class,$category);

        $categoryForm->handleRequest($request);
        //si on submit le formulaire
        if($categoryForm->isSubmitted()){
            //ajout de la catégorie en base
            $category->setDateAjout(new \DateTime('@'.strtotime('now')));
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'catégorie ajouté!');
            //on affiche la liste des catégories
            return $this->redirectToRoute('Categorie_list');
        }

        //on envoit le formulaire a la page d'ajout de category
        return $this->render('categorie/ajoutcategorie.html.twig',['categoryForm' =>$categoryForm->createView()]);
    }
}