<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntispamValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            // On ignore les valeurs vides, car NotBlank/Length gèrent ça
            return;
        }

        // Teste que la valeur contient uniquement des lettres a-z ou A-Z
        if (!preg_match('/^[a-zA-Z]+$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
