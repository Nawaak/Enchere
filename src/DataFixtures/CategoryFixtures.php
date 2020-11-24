<?php

namespace App\DataFixtures;

use App\Entity\Bidding;
use App\Entity\Category;
use App\Entity\OfferBidding;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CategoryFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $usera = new User();
        $usera->setEmail('admin@admin.fr')
            ->setUsername('Brandon')
            ->setPassword($this->encoder->encodePassword($usera,'admin'))
            ->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $manager->persist($usera);

        $users[] = $usera;
        for ($i = 0; $i <= 15; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setUsername($faker->firstNameMale)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i <= 3; $i++) {
            $category = new Category();
            $category->setName($faker->word())
                ->setImage('https://mdbootstrap.com/img/Photos/Others/photo' . mt_rand(4, 15) . '.jpg');
            $manager->persist($category);

            for ($b = 0; $b <= mt_rand(8, 15); $b++) {
                $bidding = new Bidding();
                $bidding->setName($faker->word())
                    ->setImage('https://mdbootstrap.com/img/Photos/Others/photo' . mt_rand(1, 9) . '.jpg')
                    ->setContent($faker->text(400))
                    ->setCategory($category)
                    ->setExpireAt($faker->dateTimeBetween('now', '+1 month', 'Europe/Paris'))
                    ->setExpire(false)
                    ->setStartPrice($faker->randomFloat(0,100,1000))
                    ->setUser($faker->randomElement($users));
                $manager->persist($bidding);

                for ($o = 0; $o <= mt_rand(2, 6); $o++) {
                    $Offer = new OfferBidding;
                    $Offer->setPrice($faker->randomFloat(0,$bidding->getStartPrice(), $bidding->getStartPrice() + mt_rand(0, 35)))
                        ->setBidding($bidding)
                        ->setUser($faker->randomElement($users));
                    $manager->persist($Offer);
                }
            }
        }

        $manager->flush();
    }
}
