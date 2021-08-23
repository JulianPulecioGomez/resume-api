<?php

namespace App\Request\Validation;

use App\Repository\UserRepository;
use App\Request\UserRequest;
use App\Request\Validation\UniqueEmailConstraint;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class UniqueEmailConstraintValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEmailConstraint) {
            throw new UnexpectedTypeException($constraint, UniqueEmailConstraint::class);
        }

        if (!$value instanceof UserRequest) {
            throw new \InvalidArgumentException($constraint, UserRequest::class);
        }

        if ('' === $value) {
            return;
        }

        if (!is_string($value->getEmail())) {
            throw new UnexpectedValueException($value->getEmail(), 'string');
        }

        if ($value->getEmail() && $this->repository->findByEmail($value->getEmail())) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value->getEmail())
                ->addViolation();
        }
    }
}