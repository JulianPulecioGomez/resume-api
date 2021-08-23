<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Entity\Tag;
use App\Request\ProductRequest;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateProductUseCase
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }

    public function handle(ProductRequest $request): Product
    {
        $product = Product::createFromRequest($request);

        foreach ($request->getTags() as $tag){
            $product->addTag($tag);
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
