<?php

namespace App\Serializer;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CustomSerializer implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(
    )
    {
        $this->serializer = new Serializer(
                [new ArrayDenormalizer(),
                        new ObjectNormalizer(
                                null, null, null,
                                new PropertyInfoExtractor([], [new ReflectionExtractor()])
                        )
                ],[new JsonEncoder()]
        );
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data,$type, $format, $context);
    }
}