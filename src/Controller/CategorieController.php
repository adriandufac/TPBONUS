<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function ajout(){
        return $this->render('categorie/ajoutcategorie.html.twig');
    }
}