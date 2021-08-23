<?php

namespace App\Request;

use App\Util\RequestDTOInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Request\Validation\UniqueEmailConstraint as UserEmailConstraint;

/**
 * @author Julian Pulecio
 * @UserEmailConstraint()
 */
class UserRequest extends ApiRequest implements RequestDTOInterface
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;


    /**
     * @var string
     * @Assert\NotBlank
     */
    private $password;

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}

