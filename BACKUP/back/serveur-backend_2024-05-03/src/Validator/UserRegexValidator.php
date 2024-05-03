<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserRegexValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint): void
    {


        if (!$constraint instanceof UserRegex) {
            throw new UnexpectedTypeException($constraint, UserRegex::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!\is_scalar($value) && !$value instanceof \Stringable) {
            throw new UnexpectedValueException($value, 'string');
        }

        $value = (string) $value;

        if (null !== $constraint->normalizer) {
            $value = ($constraint->normalizer)($value);
        }

        if ($constraint->match xor preg_match($constraint->pattern, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setParameter('{{ pattern }}', $constraint->pattern)
                ->setParameter('{{ entity }}', $constraint->entity)
                ->setParameter('{{ field }}', $constraint->field)
                ->setCode(UserRegex::USERREGEX_FAILED_ERROR)
                ->addViolation();
        }
    }
}
