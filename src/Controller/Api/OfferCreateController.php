<?php


namespace App\Controller\Api;


use App\Entity\OfferBidding;
use Symfony\Component\Security\Core\Security;

class OfferCreateController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(OfferBidding $data)
    {
        $data->setUser($this->security->getUser());
        return $data;
    }


}