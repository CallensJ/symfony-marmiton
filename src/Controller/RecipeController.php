<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recettes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository  $repository, EntityManagerInterface $em): Response

    {
        // $recipes = $repository->findWithDurationLowerThan(10);
        $recipes = $repository->findAll();
        //     //creer nouvelle recette
        //     $recipe = new Recipe();
        // $recipe->setTitle('gateau a la fraise')
        //     ->setSlug('gateau-fraise')
        //     ->setContent('sucre et fraises')
        //     ->setDuration(20)
        //     ->setCreatedAt(new \DateTimeImmutable())
        //     ->setUpdatedAt(new \DateTimeImmutable());
        // $em->persist($recipe);
        // $em->flush();

        // //supprimer une recette

        // $em->remove($recipes[1]);
        // $em->flush();
        //modifier le titre de la recette.
        // $recipes[0]->setTitle('Pates Bolognaiseeuuhh');
        // $em->flush();
        // dd($recipes);
        // return new Response('Recettes');
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    #[Route('/recettes/{slug}-{id}', name: 'recipe.show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        // return $this->json([
        //     'slug' => $slug
        // ]);
        // dd($request->attributes->get("slug"), $request->attributes->get('id'));
        // return new Response('Recette : . $slug');

        $recipe = $repository->find($id);
        //dd($recipe);
        //redirection si slug url est different du slug
        if ($recipe->getSlug() !== $slug) {
            return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
        }
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe
            // 'slug' =>$slug,
            // "person" => [
            //     'firstname' => 'Johan',
            //     'lastname' => 'Doe'
            // ],   
            // 'id' =>$id
        ]);
    }


    #[Route('/recettes/{id}/edit', name: 'recipe.edit', methods:['GET', 'POST'])]
    // public function edit(int $id)
    // {

    public function edit(Recipe $recipe, Request $request, EntityManagerInterface $em)
    {
        // dd($recipe);

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); //save
            $recipe->setUpdatedAt(new \DateTimeImmutable()); //update datetime
            $this->addFlash('ok', 'modifications apportees avec success');
            return $this->redirectToRoute('recipe.index'); //redirect 
        }
        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form
        ]);
    }

    #[Route('/recettes/create', name: 'recipe.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $recipe->setCreatedAt(new \DateTimeImmutable());
            $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette cree');
            return $this->redirectToRoute('recipe.index');
        }
        return $this->render('recipe/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/recettes/{id}', name: 'recipe.delete', methods:['DELETE'])]
    public function delete(Recipe $recipe, EntityManagerInterface $em){
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'Recette supprimee');
        return $this->redirectToRoute('recipe.index');
    }
}
