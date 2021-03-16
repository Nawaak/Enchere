<?php

namespace App\MeiliSearch\Normalizer;

use App\Entity\Bidding;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class BiddingNormalizer implements ContextAwareNormalizerInterface
{

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Bidding;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'content' => $object->getContent()
        ];
    }
}