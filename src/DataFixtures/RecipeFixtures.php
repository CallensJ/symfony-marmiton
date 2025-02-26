<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;

class RecipeFixtures
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $recipe = (new Recipe())
                ->setTitle("recipeTitle");
            $manager->persist($recipe);
        }
        $manager->flush();
    }
}
