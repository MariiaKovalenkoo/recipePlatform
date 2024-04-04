<?php

namespace App\Models\Enums;

class EnumMapper {
    public static function toArray(string $enumClass): ?array
    {
        try {
            $reflectionClass = new \ReflectionClass($enumClass);
            $constants = $reflectionClass->getConstants();
            $values = array_values($constants);

            return array_combine($values, $values);
        } catch (\ReflectionException $e) {
            return null;
        }
    }
    public static function mapToEnum(string $enumClass, string $inputString): ?string {
        if (!class_exists($enumClass)) {
            return null;
        }

        $reflectionClass = new \ReflectionClass($enumClass);
        $constants = $reflectionClass->getConstants();

        //$inputString = str_replace('_', ' ', $inputString);
        foreach ($constants as $constant => $value) {
            if (strtoupper($inputString) === $value) {
                return $value;
            }
        }
        return null;
    }
}