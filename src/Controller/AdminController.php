<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /* ADMIN PAGE */

    /**
     * @Route("/admin", name="admin_home")
     */
    public function admin(ArticleRepository $articleRepo): Response
    {
        return $this->render('admin/admin.html.twig', [
            
        ]);
    }

    /* ADMIN ARTICLE */

    /**
     * @Route("/admin/articles", name="admin_article_list")
     */
    public function adminlist(ArticleRepository $articleRepo): Response
    {
        $articles = $articleRepo->findAll();
        return $this->render('admin/adminlist.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article", name="admin_article_new")
     * @Route("/admin/article/{id}", name="admin_article_edit")
     */
    public function adminedit(Int $id = null, Article $article = null, Request $request): Response
    {
        if (!$article) {
        // au lieu de 
        // if ($article){
            $article = new Article();
        }
        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Enregistrer')->isClicked()) {
               $article->setDatePublication(new DateTime());
                $this->entityManager->persist($article);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_article_edit', ['id' => $article->getId()]);
            }

            if ($form->get('Supprimer')->isClicked()) {
                $this->entityManager->remove($article);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_article_list');
            }
        }

        return $this->render('admin/adminedit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /* ADMIN CATEGORIE */

    /**
     * @Route("/admin/categories", name="admin_categorie_list")
     */
    public function categorielist(CategorieRepository $categorieRepo): Response
    {
        $categories = $categorieRepo->findAll();
        return $this->render('admin/categorielist.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/categorie", name="admin_categorie_new")
     * @Route("/admin/categorie/{id}", name="admin_categorie_edit")
     */
    public function categorieedit(Categorie $categorie = null, Request $request): Response
    {
        if ($categorie == null) $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Enregistrer')->isClicked()) {
                $categorie->setDatePublication(new DateTime());
                $this->entityManager->persist($categorie);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_categorie_edit', ['id' => $categorie->getId()]);
            }

            if ($form->get('Supprimer')->isClicked()) {
                $this->entityManager->remove($categorie);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_categorie_list');
            }
        }

        return $this->render('admin/categorieedit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
