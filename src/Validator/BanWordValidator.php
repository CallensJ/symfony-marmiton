<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BanWordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BanWord $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $value = strtolower($value);
        //for each banwords if $value contain banWord then buildViolation
        foreach($constraint->banWords as $banWord){
            if (str_contains($value, $banWord)){
                
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $banWord)
                    ->addViolation();
            }
        }


    }
}
