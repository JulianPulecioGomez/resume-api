<?php

namespace App\Controller;

use App\Entity\Product;
use App\Request\ProductRequest;
use App\Service\Product\CreateProductUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __invoke(ProductRequest $request, CreateProductUseCase $useCase)
    {
        return $useCase->handle($request);
    }
}
