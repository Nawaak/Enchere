<?php

namespace App\DataFixtures;

use App\Entity\Bidding;
use App\Entity\Category;
use App\Entity\OfferBidding;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i =0; $i <= 3; $i++) {
            $category = new Category();
            $category->setName($faker->word())
                ->setImage('https://mdbootstrap.com/img/Photos/Others/photo'.mt_rand(4,15).'.jpg');
            $manager->persist($category);

            for ($b = 0; $b <= mt_rand(8, 15); $b++) {
                $bidding = new Bidding();
                $bidding->setName($faker->word())
                    ->setImage('https://mdbootstrap.com/img/Photos/Others/photo'.mt_rand(1,9).'.jpg')
                    ->setContent($faker->text(400))
                    ->setCategory($category)
                    ->setExpireAt($faker->dateTimeBetween('now', '+1 hours   ', 'Europe/Paris'))
                    ->setExpire(mt_rand(0,1))
                    ->setStartPrice(mt_rand(29,3900));
            for ($o = 0; $o <= mt_rand(2,6); $o++){
                $Offer = new OfferBidding;
                $Offer->setPrice(mt_rand($bidding->getStartPrice(),$bidding->getStartPrice() + mt_rand(9,35)))
                    ->setBidding($bidding);
                    $manager->persist($Offer);
            }
            $manager->persist($bidding);
            }
        }

        $manager->flush();
    }
}
