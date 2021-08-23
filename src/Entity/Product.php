<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use App\Controller\ProductController;
use App\Controller\AddImageToProductController;
use App\Request\ProductRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Tag;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *     collectionOperations={
 *        "get",
 *        "post_publication"={
 *              "method"="POST",
 *              "path"="/product/create",
 *              "validate"=false,
 *              "controller"=ProductController::class,
 *        },
 *
 *    },
 *    itemOperations={
 *       "get",
 *       "put",
 *       "patch",
 *       "delete",
 *       "add_image"={
 *           "method"="POST",
 *           "path"="/product/{id}/add_image",
 *           "validate"=false,
 *           "controller"=AddImageToProductController::class,
 *           "deserialize"=false,
 *           "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *       }
 *    }
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:write","product:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"product:write","product:read"})
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"product:write","product:read"})
     */
    private $description;

    /**
     * @var ArrayCollection<\App\Entity\Tag>
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="products", cascade={"persist","remove","merge"})
     * @Groups({"product:write","product:read"})
     */
    private $tags;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    public function __construct(
        string $name,
        int $price,
        string $description = ''
    ) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setDescription($description);
        $this->tags = new ArrayCollection();
    }

    public static function createFromRequest(ProductRequest $request): self{
        return new static(
            $request->getName(),
            $request->getPrice(),
            $request->getDescription()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getName(): ?string
    {
        return $this->name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);
        return $this;
    }
}
