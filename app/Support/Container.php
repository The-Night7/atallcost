<?php

declare(strict_types=1);

namespace App\Support;

use RuntimeException;

final class Container
{
    private array $entries = [];
    private array $resolved = [];

    public function set(string $id, mixed $value): void
    {
        $this->entries[$id] = $value;
    }

    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        if (!array_key_exists($id, $this->entries)) {
            if (!class_exists($id)) {
                throw new RuntimeException("Service non trouve: {$id}");
            }

            return $this->resolved[$id] = $this->build($id);
        }

        $entry = $this->entries[$id];
        if ($entry instanceof \Closure) {
            return $this->resolved[$id] = $entry($this);
        }

        return $this->resolved[$id] = $entry;
    }

    public function build(string $class): object
    {
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if ($constructor === null) {
            return new $class();
        }

        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                throw new RuntimeException("Impossible d'injecter {$class}");
            }
            $arguments[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($arguments);
    }
}
