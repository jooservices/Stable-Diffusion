<?php

namespace App\Services\StableDiffusion\Traits;

use Illuminate\Support\Collection;

trait HasValues
{
    protected Collection $properties;

    protected function bootHasValues()
    {
        $this->properties = collect();
    }

    public function addValue(string $value): self
    {
        $this->properties->add(trim($value));

        return $this;
    }

    public function addManyValues(string $values): self
    {
        collect(explode(',', $values))->each(function ($value) {
            $this->addValue($value);
        });

        return $this;
    }

    public function removeValue(string $value): self
    {
        $this->properties->each(function ($item, $key) use ($value) {
            if ($item === $value) {
                $this->properties->forget($key);
            }
        });

        return $this;
    }

    public function loadValuesFromFile(string $path): self
    {
        $values = trim($this->filesystem->get($path), "\n");
        $this->addManyValues($values);

        return $this;
    }

    public function loadValuesFromArray(array $values): self
    {
        $this->properties = $this->properties->merge($values);

        return $this;
    }

    public function getValues(): array
    {
        return $this->properties->unique()->filter()->toArray();
    }

    public function getValueJson(): string
    {
        return json_encode($this->getValues());
    }

    public function getValuesString(): string
    {
        return implode(',', $this->getValues());
    }
}
