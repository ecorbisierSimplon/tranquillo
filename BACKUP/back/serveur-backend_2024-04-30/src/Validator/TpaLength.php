<?php

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\MissingOptionsException;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class TpaLength extends Constraint
{
    public const TOO_SHORT_ERROR = '9ff3fdc4-b214-49db-8718-39c315e33d45';
    public const TOO_LONG_ERROR = 'd94b19cc-114f-4f44-9cc4-4138e80a87b9';
    public const NOT_EQUAL_LENGTH_ERROR = '4b6f5c76-22b4-409d-af16-fbe823ba9332';
    public const INVALID_CHARACTERS_ERROR = '35e6a710-aa2e-4719-b58e-24b35749b767';

    protected const ERROR_NAMES = [
        self::TOO_SHORT_ERROR => 'TOO_SHORT_ERROR',
        self::TOO_LONG_ERROR => 'TOO_LONG_ERROR',
        self::NOT_EQUAL_LENGTH_ERROR => 'NOT_EQUAL_LENGTH_ERROR',
        self::INVALID_CHARACTERS_ERROR => 'INVALID_CHARACTERS_ERROR',
    ];

    public const COUNT_BYTES = 'bytes';
    public const COUNT_CODEPOINTS = 'codepoints';
    public const COUNT_GRAPHEMES = 'graphemes';

    private const VALID_COUNT_UNITS = [
        self::COUNT_BYTES,
        self::COUNT_CODEPOINTS,
        self::COUNT_GRAPHEMES,
    ];

    public string $maxMessage = 'Cette valeur est trop longue. Elle doit contenir {{ limit }} caractères ou moins.|Cette valeur est trop longue. Il doit contenir {{ limit }} caractères ou moins.';
    public string $minMessage = 'Cette valeur est trop courte. Il doit contenir {{ limit }} caractères ou plus.|Cette valeur est trop courte. Il doit contenir {{ limit }} caractères ou plus.';
    public string $exactMessage = 'Cette valeur doit contenir exactement {{ limit }} caractères.|Cette valeur doit contenir exactement {{ limit }} caractères.';
    public string $charsetMessage = 'Cette valeur ne correspond pas au jeu de caractères {{ charset }} attendu.';
    public ?int $max = null;
    public ?int $min = null;
    public string $charset = 'UTF-8';
    /** @var callable|null */
    public $normalizer;
    /** @var self::COUNT_* */
    public string $countUnit = self::COUNT_CODEPOINTS;

    /**
     * @param self::COUNT_*|null $countUnit
     */
    public function __construct(
        int|array|null $exactly = null,
        ?int $min = null,
        ?int $max = null,
        ?string $charset = null,
        ?callable $normalizer = null,
        ?string $countUnit = null,
        ?string $exactMessage = null,
        ?string $minMessage = null,
        ?string $maxMessage = null,
        ?string $charsetMessage = null,
        ?array $groups = null,
        mixed $payload = null,
        array $options = []
    ) {
        if (\is_array($exactly)) {
            $options = array_merge($exactly, $options);
            $exactly = $options['value'] ?? null;
        }

        $min ??= $options['min'] ?? null;
        $max ??= $options['max'] ?? null;

        unset($options['value'], $options['min'], $options['max']);

        if (null !== $exactly && null === $min && null === $max) {
            $min = $max = $exactly;
        }

        parent::__construct($options, $groups, $payload);

        $this->min = $min;
        $this->max = $max;
        $this->charset = $charset ?? $this->charset;
        $this->normalizer = $normalizer ?? $this->normalizer;
        $this->countUnit = $countUnit ?? $this->countUnit;
        $this->exactMessage = $exactMessage ?? $this->exactMessage;
        $this->minMessage = $minMessage ?? $this->minMessage;
        $this->maxMessage = $maxMessage ?? $this->maxMessage;
        $this->charsetMessage = $charsetMessage ?? $this->charsetMessage;

        if (null === $this->min && null === $this->max) {
            throw new MissingOptionsException(sprintf('L\'option "min" ou "max" doit être donnée pour la contrainte "%s".', __CLASS__), ['min', 'max']);
        }

        if (null !== $this->normalizer && !\is_callable($this->normalizer)) {
            throw new InvalidArgumentException(sprintf('L\'option "normalizer" doit être un appelable valide ("%s" donné).', get_debug_type($this->normalizer)));
        }

        if (!\in_array($this->countUnit, self::VALID_COUNT_UNITS)) {
            throw new InvalidArgumentException(sprintf('L\'option "countUnit" doit être l\'une des constantes "%s"::COUNT_* ("%s" donné).', __CLASS__, $this->countUnit));
            // throw new InvalidArgumentException(sprintf('The "countUnit" option must be one of the "%s"::COUNT_* constants ("%s" given).', __CLASS__, $this->countUnit));
        }
    }
}
