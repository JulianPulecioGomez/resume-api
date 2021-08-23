<?php

namespace App\Request;

use App\Entity\Product;
use App\Entity\Tag;
use App\Util\RequestDTOInterface;
use phpDocumentor\Reflection\Types\Collection;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Julian Pulecio
 */
class ProductRequest implements RequestDTOInterface
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var integer
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Collection|Tag[]
     */
    private $tags;

    /**
     * @var Product
     */
    private $product;

    public function __construct(Request $request)
    {
        $product = $request->attributes->get('data');

        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->description = $product->getDescription();
        $this->tags = $product->getTags();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Tag[]|Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[]|Collection $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }
}
