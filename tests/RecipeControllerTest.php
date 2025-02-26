<?php 
//https://symfony.com/doc/current/the-fast-track/en/17-tests.html#loading-fixtures
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase{

    public function testHomePage(){
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Marmiton !');
    }

    public function testRecipesPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recettes');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.recipe-card'); //verifie element html present ou non
    }
}
?>