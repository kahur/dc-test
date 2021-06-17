<?php

namespace DC\Service\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ValidatorAbstract
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * ValidatorAbstract constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return Collection
     */
    abstract public function getValidatorConstrains(): Collection;

    /**
     * @param array $data
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate(array $data)
    {
        return $this->validator->validate($data, $this->getValidatorConstrains());
    }
}