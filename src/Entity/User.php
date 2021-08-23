<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Request\UserRequest;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\RegisterUserController;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class),
 * @ApiResource(collectionOperations={
 *     "get",
 *     "post_publication"={
 *         "method"="POST",
 *         "path"="/user/create",
 *         "validate"=false,
 *         "controller"=RegisterUserController::class,
 *     }
 * })
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct(string $email){
        $this->email = $email;
    }

    public static function createFromRequest(UserRequest $request): self{

        return new static($request->getEmail());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
