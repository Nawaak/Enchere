<?php


namespace App\Tests\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CategoryControllerTest extends WebTestCase
{

    public function testShowSuccess(): void
    {
        /** @var CategoryRepository $categoryRepo */
        $client = static::createClient();
        $categoryRepo = static::$container->get(CategoryRepository::class);
        $category = $categoryRepo->findOneBy(['id' => 153]);
        $client->request('GET',"/categorie/{$category->getSlug()}");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}