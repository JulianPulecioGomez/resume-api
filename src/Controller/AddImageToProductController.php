<?php

namespace App\Controller;

use App\Entity\Product;
use App\Request\ProductRequest;
use App\Service\Product\AddImageToProduct;
use App\Service\Product\CreateProductUseCase;
use App\Service\UploadImage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddImageToProductController extends AbstractController
{
    public function __invoke(Product $data, Request $request, AddImageToProduct $useCase): Product
    {
        return $useCase->handle($data,$request);
    }
}
