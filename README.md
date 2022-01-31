# BLOG DEMO PHP SYMFONY - MySQL

## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Project Directory](#project-directory)
5. [DB Configuration](#db-configuration)
6. [Controller](#controller)
7. [Entity](#entity)
8. [Relationships between Entities](#relationships-between-entities)
9. [Template](#template)
10. [Authenticating Users](#authenticating-users)
11. [DoctrineFixturesBundle](#doctrine-fixtures-bundle)
12. [Writing Fixtures](#writing-fixtures)
13. [Loading Fixtures](#loading-fixtures)
14. [Paginating](#paginating)
15. [Add Article](#add-article)

# General Info
Exemple de creation d'un blog demo  basé sur le tutoriel de [Nouvelle Techno](https://nouvelle-techno.fr/articles/recherche?mots=blog).

# Technologies
* O.S. Windows 10
* PHP 7.2.5
* Symfony 5.4
* MySQL 5.7

# Installation
* git clone https://github.com/ioanamatac/blog_demo_symfony_mySQL.git
* cd project
* php bin/console server:run

# Project create
>Creation projet : 
* composer create-project symfony/skeleton blogDemo
* cd blogDemo

# DB Configuration
> Dans le fichier .env :
```DATABASE_URL="mysql://root@127.0.0.1:3306/blogdemo?serverVersion=5.7"```
# Controller 
>Creation d'un controleur : 
* composer require doctrine maker –dev
* php bin/console make:controller 
# Entity 
>Creation d'un user :
* php bin/console make:user
>Creation d'un model :
* php bin/console make:entity

# Relationships between Entities
Entity   |Type Relation | Entity          | Description

------------- |:------------- |:----------- |:-----------

`ARTICLE`       | `ManyToOne`        | `USER` | `Each Article can relate to (can have) one User object.
               Each User can also relate to (can also have) many Articles objects.`

`ARTICLE`        |  `OneToMany`     |  `COMMENTAIRE` |  `Each Article can relate to (can have) many Commentaires objects.
               Each Commentaire can also relate to (can also have) one Article object.` 

`ARTICLE`       | `ManyToMany`   | `MOTS_CLE`| `Each Article can relate to (can have) many Commentaires objects.
               Each Commentaire can also relate to (can also have) many Articles objects.`

`ARTICLE`        | `ManyToMany`  | `CATEGORIE`| `Each Article can relate to (can have) many Categories objects.
               Each Categorie can also relate to (can also have) many Articles objects.`

>Exemple de creation relation entre Article et Commentaire :
```php

 Class name of the entity to create or update (e.g. Ti
 > Article

 Your entity already exists! So let's add some new fie

 New property name (press <return> to stop adding fiel
 > commentaire

 Field type (enter ? to see all types) [string]:
 > relation

y Article objects

  OneToMany    Each Article can relate to (can have) many 
Commentaire objects.
               Each Commentaire relates to (has) one Article

  ManyToMany   Each Article can relate to (can have) many 
Commentaire objects.
               Each Commentaire can also relate to (can also have) many Article objects

  OneToOne     Each Article relates to (has) exactly one Commentaire.
               Each Commentaire also relates to (has) exactly one Article.
 ------------ --------------------------------------------------------------------------

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > OneToMany

 A new property will also be added to the Commentaire class so that you can access and set the related Article object from it.

 New field name inside Commentaire [article]:
 >

 Is the Commentaire.article property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to activate orphanRemoval on your relationship?
 A Commentaire is "orphaned" when it is removed from its related Article.
 e.g. $article->removeCommentaire($commentaire)

 NOTE: If a Commentaire may *change* from one Article to another, answer "no".
 Do you want to automatically delete orphaned App\Entity\Commentaire objects (orphanRemoval)? (yes/no) [no]:        
 > yes

 updated: src/Entity/Article.php
 updated: src/Entity/Commentaire.php
 ```
 
 
# Template 
>Creation de la route dans le Controleur :
```php 
    /**
     * @Route("/main/{id}", name="main_show")
     */
    public function show( Article $article): Response { 
      
        
        return $this->render('main/show.html.twig',[
            'article' => $article,
           
        ]);
    }
```
>Creation de la vue. Exemple : show.html.twig 
```php 
{% extends 'base.html.twig' %}
    {% block title %} SymBlog {% endblock %}
    {% block body %}
        <div class="container">
            <section>
                <article >                                      
                    <!-- Card Regular -->
                    <div class="card card-cascade mt-2">
                        <!-- Card content -->
                        <div class="card-body card-body-cascade">
                        <!-- Title -->
                        <h4 class="card-title"><strong>{{ article.titre }}</strong></h4>
                        <!-- Subtitle -->                     
                        <h6 class="font-weight-bold indigo-text py-2">{{ article.slug }}</h6>
                        <!-- Text -->
                        <p class="card-text">Ecrit le {{ article.createdAt| date('d/m/Y') }} à {{ article.createdAt | date('H:i') }} </p>
                        <p class="card-content"><i class="fas fa-quote-left pe-2"></i> {{ article.contenu }}</p>
                            {% for commentaire in article.commentaire %}
                                    <p class="card-text"><i>Commentaire</i> écrit le {{ commentaire.createdAt| date('d/m/y') }} à {{ commentaire.createdAt| date('H:i')}} par <i class="fas fa-user-ninja vanished"></i>{{ commentaire.pseudo }}:</p>                                    
                                    <p class="card-content"> {{ commentaire.contenu }}
                            {% endfor %}
                        <div><a href="{{ path('main', {'id': article.id }) }}" class="btn btn-dark">Go back</a></div>                                                        
                    </div>                                                               
                </article>                        
            </section>        
        </div>
    {% endblock %} 
```       
# Authenticating Users
* php bin/console make:auth

# DoctrineFixturesBundle
>Les "fixtures" sont utilisés pour charger un « fake » ensemble de données dans une base de données qui peut ensuite être utilisée pour tester ou pour vous aider à obtenir des données intéressantes pendant que vous développez votre application.

>Installation:
* composer require --dev orm-fixtures 
* composer require fakerphp/faker 

# Writing Fixtures
>Exemple ArticleFixtures
```php 
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i < 30; $i++) {
            $article = new Article();
            $user = $this->getReference('user_'.$faker->numberBetween(1,10));  
            $categorie = $this->getReference('categorie_'.$faker->numberBetween(1,10));          
            $article->setUser($user);        
                      
            $article->setTitre($faker->text(50));            
            $article->setContenu($faker->text(200));
            $article->setSlug($faker->word(60));
            $article->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));
            $article->setUpdatedAt($faker->dateTimeBetween('-6 month', 'now'));
            $article->setImageArticle("http://placeholder.it/150x150");                   
          
            $manager->persist($article);          
            $this->addReference('article_'. $i, $article);
        }
        $manager->flush();
    }
    public function getDependencies(){

        return [
            CategorieFixtures::class,
            UserFixtures::class
        ];
    }   
    
} 
```
>Exemple Class CommentaireFixtures
```php
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Commentaire;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=1; $i < 30; $i++) {
            $commentaire = new Commentaire();
            $article = $this->getReference('article_'.$faker->numberBetween(1,30)); 
            $commentaire->setArticle($article);            
            $commentaire->setContenu($faker->text(200));
            $commentaire->setActif($faker->numberBetween(0, 1));
            $commentaire->setEmail($faker->email);
            $commentaire->setPseudo($faker->word(30));
            $commentaire->setRgpd($faker->numberBetween(0, 1));
            $commentaire->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'));     
       
            $manager->persist($commentaire);
            $this->addReference('commentaire_'. $i, $commentaire);
        }    
        $manager->flush();
    }    
    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            CategorieFixtures::class
        ]; 
    }
   
}

```
# Loading Fixtures
* php bin/console doctrine:fixtures:load

# Paginating
>Gerer la pagination :
* composer require knplabs/knp-paginator-bundle
>Ajouter dans config->packages->twig.yaml
```php
twig:
    default_path: '%kernel.project_dir%/templates'
    path: '%kernel.project_dir%/vendor/knplabs/knp-paginator-bundle/templates'
```
>Et dans la vue (à l'interieur des balises body) :
```php 
{{knp_pagination_render(articles)}}
```
>Dans le Controleur : 
* Use Knp\Component\Pager\PaginatorInterface; 
* Use Symfony\Component\HttpFondation\Request;

>Un exemple : 
```php 
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
```
# Add Article
>Pour la creation d'un article (ArticleType):
* php bin/console make:form
>Dans le controlleur : 
```php
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
```
>Et dans config->routes.yaml
```php
new:
    path: /main/new
    controller: App\Controller\MainController::new
    methods:    GET |POST
```
>La vue :  new.html.twig
```php
{% extends 'base.html.twig' %}

{% form_theme form 'bootstrap_5_layout.html.twig' %}

{% block title %}Creation article{% endblock %}

{% block body %}
    <div class="container mt-3 ">
        <h3>Creation d'un article</h3>
        <div class="form-row ">
            <div class="form-group col-md-4 ">

                {{ form_start(form) }}
                {{ form_widget(form) }}
                    <button class="btn btn-success">Créer un article</button>
                {{ form_end(form) }}

            </div>
        </div>
    </div>
{% endblock %}    
```               
Enjoy !:)
Ioana