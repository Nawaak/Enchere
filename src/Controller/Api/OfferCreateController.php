<?php

namespace App\Controller\Api;

use App\Entity\OfferBidding;
use App\Entity\User;
use App\Repository\OfferBiddingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class OfferCreateController extends AbstractController
{
    private Security $security;

    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * @Route(
     *     name="api_offer_biddings_post_publication",
     *     path="/api/offer_biddings",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=OfferBidding::class,
     *         "_api_collection_operation_name"="post"
     *     }
     * )
     * @param OfferBidding $data
     * @param OfferBiddingRepository $repo
     * @return OfferBidding|JsonResponse
     */
    public function __invoke(OfferBidding $data, OfferBiddingRepository $repo)
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $data->setUser($user);

        $now = new \DateTime('now');

        $lastOffer = $repo->findLastOffer($data->getBidding());

        // Si l'offre à expirer, on retourne un JSON (422), enchère impossible
        if($data->getBidding()->getExpireAt()->format('Y m d h:i:s') <= $now->format('Y m d h:i:s')){
            return new JsonResponse(['type' => 'danger', 'message' => "L'enchère a expirer, vous ne pouvez plus faire d'offre"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Si le prix proposer est inférieur ou égale a la derniere offre on retourne en JSON
        if($data->getPrice() <= $lastOffer[0]->getPrice()){
            return new JsonResponse(['type' => 'danger', 'message' => 'Votre enchère doit être supérieur a la derniere offre'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $data;
    }
}