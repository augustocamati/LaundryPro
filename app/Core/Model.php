<?php

namespace App\Core;

abstract class Model {
    /**
     * Map array data to object properties.
     *
     * @param array $data
     */
    public function __construct(array $data = []) {
        foreach ($data as $key => $value) {
            $property = $this->toCamelCase($key);
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Convert properties to array representation for DB.
     *
     * @return array
     */
    public function toArray(): array {
        $array = [];
        // Use reflection or get_object_vars to retrieve all properties including private/protected ones of the subclass
        $properties = (new \ReflectionClass($this))->getProperties();
        
        foreach ($properties as $property) {
            $property->setAccessible(true);
            if ($property->isInitialized($this)) {
                $value = $property->getValue($this);
                $dbKey = $this->toSnakeCase($property->getName());
                $array[$dbKey] = $value;
            } else {
                $dbKey = $this->toSnakeCase($property->getName());
                $array[$dbKey] = null;
            }
        }
        return $array;
    }

    /**
     * Convert snake_case to camelCase.
     */
    private function toCamelCase(string $string): string {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    /**
     * Convert camelCase to snake_case.
     */
    private function toSnakeCase(string $string): string {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}
