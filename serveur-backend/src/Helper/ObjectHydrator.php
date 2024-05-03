<?php

namespace App\Helper;

use App\Dto\TaskDto;
use App\Entity\Task;

class ObjectHydrator
{
    public static function hydrate(array $content, object $dto)
    {

        foreach ($content as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }
        return $dto;
    }
}
