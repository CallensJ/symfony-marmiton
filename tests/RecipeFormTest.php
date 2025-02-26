<?php
namespace App\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\Recipe;
use App\Form\RecipeType;

class RecipeFormTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'Tarte aux fraises',
            'content' => 'Une délicieuse tarte aux fraises maison',
            'ingredients' => 'Fraises, pâte sablée, crème pâtissière',
        ];

        $model = new Recipe();
        $form = $this->factory->create(RecipeType::class, $model);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized()); // Vérifie que le formulaire a bien fonctionné
        $this->assertEquals('Tarte aux fraises', $model->getTitle());
        $this->assertEquals('Une délicieuse tarte aux fraises maison', $model->getContent());
    }
}


?>