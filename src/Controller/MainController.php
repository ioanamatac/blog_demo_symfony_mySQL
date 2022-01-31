<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;



class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index (ArticleRepository $repo, Request $request, PaginatorInterface $paginator): Response
    {
       $donnees = $articles = $repo->findAll();
       $articles = $paginator->paginate(
           $donnees,
           $request->query->getInt('page', 1),   //Numero de la page en cours, 1 par default
          4
       );
        return $this->render('main/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator) {

        $donnees = $doctrine->getRepository(Article::class)->findAll();
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),   //Numero de la page en cours, 1 par default
            4
        );
        return $this->render('main/home.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/main/new",  name = "main_new",  methods={"GET", "POST"})   
     * @param Article
     */
    public function new( Request $request, EntityManagerInterface $entityManager){
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $article = $form->getData();
                $article->setUser($this->getUser());
                $entityManager->persist($article);
                $entityManager->flush(); 

            return $this->redirectToRoute('main_show', [
                     'id'=>$article->getId() ]);                
            }        
        

        return $this->renderForm('main/new.html.twig',[
            'form' => $form,
        ]);    
    }

    /**
     * @Route("/main/{id}", name="main_show")
     */
    public function show( Article $article): Response { 
      
        
        return $this->render('main/show.html.twig',[
            'article' => $article,
           
        ]);
    }
     /**
     * @Route("/main{slug}", name="main_article")
     */
    public function article(ManagerRegistry $doctrine, $slug)  {

        $article = $doctrine->getRepository(Article::class)->findOneBy([
            'slug' => $slug           
        ]);

        if(!$article){
            throw $this->render->createNotFoundException("L'article n'existe pas !");
        }
       
        return $this->render('main/article.html.twig',  [            
            compact('article')
        ]);
    }
    
}

