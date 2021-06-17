<?php

namespace DC\Service\Task\Validator;

use DC\Service\Validator\ValidatorAbstract;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskValidator extends ValidatorAbstract
{

    /**
     * @return Collection
     */
    public function getValidatorConstrains(): Collection
    {
        return new Collection([
            'title' => [
                new NotBlank()
            ],
            'description' => [
                new NotBlank()
            ],
            'start_date' => [
                new NotBlank(),
                new Date()
            ]
        ]);
    }
}