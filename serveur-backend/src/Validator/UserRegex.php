<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\InvalidArgumentException;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UserRegex extends Constraint
{
    public const USERREGEX_FAILED_ERROR = 'de1e3db3-5ed4-4941-aae4-59f3667cc3a3';

    protected const ERROR_NAMES = [
        self::USERREGEX_FAILED_ERROR => 'USERREGEX_FAILED_ERROR',
    ];
    public string $message = 'This value is not valid.';
    public ?string $pattern = null;
    public ?string $htmlPattern = null;
    public bool $match = true;
    /** @var callable|null */
    public $normalizer;

    public function __construct(
        string $regex = null,
        string|array|null $pattern = null,
        ?string $message = null,
        ?string $information = null,
        ?string $field = "champ",
        ?array $groups = null,
        mixed $payload = null,
        array $options = []
    ) {
        $pattern = ($regex === "password") ? '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%.^&§+=!])(?!.*[ç<\">[\]\'µ`~\\/]).{0,}$/' : null;
        $pattern = ($regex === "name") ? '/^[a-zA-ZÀ-ÖØ-öø-ÿ]+(?:[-_a-zA-ZÀ-ÖØ-öø-ÿ]+)[a-zA-ZÀ-ÖØ-öø-ÿ]$/' : $pattern;
        $pattern = ($regex === "number") ? '/^[0-9]\d*$/' : $pattern;

        if ($message === null) {

            $message = ($regex === "password") ? "Le mot de passe ne correspond pas aux critères de sécurités (minuscules, majuscules, chiffres, spéciaux : @#$%.^&§+=! ." : $this->message;
            $message = ($regex === "name") ? "La valeur '$field' ne répond pas aux critères de sécurité !" : $message;
            $message = ($regex === "number") ? "La valeur '$field' doit être numérique !" : $message;
        }
        if ($information != null) {
            $message .= " " . $information;
        }
        if (\is_array($pattern)) {
            $options = array_merge($pattern, $options);
        } elseif (null !== $pattern) {
            $options['value'] = $pattern;
        }

        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
        $this->htmlPattern = $htmlPattern ?? $this->htmlPattern;
        $this->match = $match ?? $this->match;
        $this->normalizer = $normalizer ?? $this->normalizer;

        if (null !== $this->normalizer && !\is_callable($this->normalizer)) {
            throw new InvalidArgumentException(sprintf('L\'option "Normalizer" doit être un appelable valide ("% s" donné).', get_debug_type($this->normalizer)));
        }
    }
    public function getDefaultOption(): ?string
    {
        return 'pattern';
    }

    public function getRequiredOptions(): array
    {
        return ['pattern'];
    }
}
