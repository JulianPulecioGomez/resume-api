<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Entity\Tag;
use App\Request\ProductRequest;
use App\Service\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AddImageToProduct
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UploadImage
     */
    private $uploadImageHelper;


    public function __construct(
        EntityManagerInterface $entityManager,
        UploadImage $uploadImageHelper
    ) {
        $this->entityManager = $entityManager;
        $this->uploadImageHelper = $uploadImageHelper;
    }

    public function handle(Product $product,Request $request): Product
    {
        $fileName = $this->uploadImageHelper->handle($request->files->get('file'));
        $product->setImage($fileName);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
