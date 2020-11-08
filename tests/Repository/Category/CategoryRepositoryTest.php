<?php


namespace App\Tests\Repository\Category;

use App\Repository\CategoryRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testCount(): void
    {
        $categories = $this->loadFixtureFiles([
            __DIR__ . '/CategoryRepositoryTestFixtures.yaml'
        ]);
        $categories = self::$container->get(CategoryRepository::class)->count([]);
        $this->assertEquals(10,$categories);
    }

}