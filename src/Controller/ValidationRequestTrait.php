<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

trait ValidationRequestTrait
{
    public function validateRequest(Request $request, Assert\Collection $constraint): array
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($request->request->all(), $constraint);

        $errors = [];
        if ($violations->count() > 0) {
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }

        return $errors;
    }
}