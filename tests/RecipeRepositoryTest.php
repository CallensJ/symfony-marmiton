<?php 

namespace App\Tests\Repository;
use App\Entity\Recipe;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecipeRepositoryTest extends KernelTestCase{

    public function testSaveRecipe(){
        self::bootKernel();
        $container = static::getContainer();
        $entityManager = $container->get('doctrine')->getManager();
       

        $recipe = new Recipe();
        $recipe = setTitle("omelete aux oeufs");
        $recipe = setSlug("entree");
        $recipe = setContent("Delicieuse ommelete aux oeufs frais");
        $recipe = setDuration("10");


        $entityManager->persist($recipe);
        $entityManager->flush();

        $recipeRepository = $entityManager->getRepository(Recipe::class);
        $savedRecipe = $recipeRepository->findOneBy(['title' => 'Soupe à l’oignon']);

        $this->assertNotNull($savedRecipe);
        $this->assertEquals('Soupe à l’oignon', $savedRecipe->getTitle());

    }
}


?>