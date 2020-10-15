<?php


namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testCategoryShow()
    {
        $client = $this->createClient();
        $categories = $this->loadFixtureFiles([__DIR__ . '/CategoryRepositoryTestFixtures.yaml']);
        $category = $categories['category1'];
        $client->request('GET',"/categorie/{$category->getSlug()}");
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains("Catégorie: {$category->getSlug()}");
    }

}