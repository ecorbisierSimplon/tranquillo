<?php

namespace App\Helper;

use ReflectionException;

class ObjectHydrator
{
    /**
     * @param array $content
     * @param object $dto
     * @return array|object
     * @throws ReflectionException
     */
    public static function hydrate(array | object $content, object $dto): array | object
    {
        if (gettype($content) == "array") {
            $dtoArray = array();

            foreach ($content as $key => $array) {
                // Assigner les valeurs du DTO à l'objet
                array_push(
                    $dtoArray,
                    self::fillObjectFromDto($array, $dto)
                );
            }
            return $dtoArray;
        }
        return self::fillObjectFromDto($content, $dto);
    }

    /**
     * @param mixed $object
     * @param mixed $dto is InterfaceDto
     * @return void
     */
    private static function fillObjectFromDto($object, $dto): object
    {
        /* Crée les instances de la classe `ReflectionObject` pour les
        `$dto` et `$object`.
        */
        $dtoReflection = new \ReflectionObject($dto);
        $objectReflection = new \ReflectionObject($object);

        /* Crée une nouvelle instance de la classe représentée par l'objet.  */
        $newDto = $dtoReflection->newInstanceWithoutConstructor();

        /**
         * Cette partie du code parcourt les propriétés de l'objet DTO à l'aide de la réflexion. Pour
         * chaque propriété, il construit le nom de la méthode setter en fonction du nom de la propriété
         * (par exemple, si la propriété est "name", la méthode setter serait "setName").
         */
        foreach ($dtoReflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $setterMethod = 'set' . ucfirst($propertyName);

            if ($objectReflection->hasMethod($setterMethod)) {
                $getterMethod = 'get' . ucfirst($propertyName);
                if ($dtoReflection->hasMethod($getterMethod)) {
                    $value = $object->$getterMethod();
                    $newDto->$setterMethod($value);
                }
            }
        }
        return $newDto;
    }
}
