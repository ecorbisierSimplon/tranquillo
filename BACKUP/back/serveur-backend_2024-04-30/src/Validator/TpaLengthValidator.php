<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class TpaLengthValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TpaLength) {
            throw new UnexpectedTypeException($constraint, TpaLength::class);
        }

        if (null === $value) {
            return;
        }

        if (!\is_scalar($value) && !$value instanceof \Stringable) {
            throw new UnexpectedValueException($value, 'string');
        }

        $stringValue = (string) $value;

        if (null !== $constraint->normalizer) {
            $stringValue = ($constraint->normalizer)($stringValue);
        }

        try {
            $invalidCharset = !@mb_check_encoding($stringValue, $constraint->charset);
        } catch (\ValueError $e) {
            if (!str_starts_with($e->getMessage(), 'mb_check_encoding() : L\'argument n°2 ($encoding) doit être un encodage valide')) {
                throw $e;
            }

            $invalidCharset = true;
        }

        $length = $invalidCharset ? 0 : match ($constraint->countUnit) {
            TpaLength::COUNT_BYTES => \strlen($stringValue),
            TpaLength::COUNT_CODEPOINTS => mb_strlen($stringValue, $constraint->charset),
            TpaLength::COUNT_GRAPHEMES => grapheme_strlen($stringValue),
        };

        if ($invalidCharset || false === ($length ?? false)) {
            $this->context->buildViolation($constraint->charsetMessage)
                ->setParameter('{{ value }}', $this->formatValue($stringValue))
                ->setParameter('{{ charset }}', $constraint->charset)
                ->setInvalidValue($value)
                ->setCode(TpaLength::INVALID_CHARACTERS_ERROR)
                ->addViolation();

            return;
        }

        if (null !== $constraint->max && $length > $constraint->max) {
            $exactlyOptionEnabled = $constraint->min == $constraint->max;

            $this->context->buildViolation($exactlyOptionEnabled ? $constraint->exactMessage : $constraint->maxMessage)
                ->setParameter('{{ value }}', $this->formatValue($stringValue))
                ->setParameter('{{ limit }}', $constraint->max)
                ->setParameter('{{ value_length }}', $length)
                ->setInvalidValue($value)
                ->setPlural((int) $constraint->max)
                ->setCode($exactlyOptionEnabled ? TpaLength::NOT_EQUAL_LENGTH_ERROR : TpaLength::TOO_LONG_ERROR)
                ->addViolation();

            return;
        }

        if (null !== $constraint->min && $length < $constraint->min) {
            $exactlyOptionEnabled = $constraint->min == $constraint->max;

            $this->context->buildViolation($exactlyOptionEnabled ? $constraint->exactMessage : $constraint->minMessage)
                ->setParameter('{{ value }}', $this->formatValue($stringValue))
                ->setParameter('{{ limit }}', $constraint->min)
                ->setParameter('{{ value_length }}', $length)
                ->setInvalidValue($value)
                ->setPlural((int) $constraint->min)
                ->setCode($exactlyOptionEnabled ? TpaLength::NOT_EQUAL_LENGTH_ERROR : TpaLength::TOO_SHORT_ERROR)
                ->addViolation();
        }
    }
}
