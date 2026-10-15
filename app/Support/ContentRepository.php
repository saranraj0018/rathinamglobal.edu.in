<?php

namespace App\Support;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Read-only access to the site's static content files in resources/data.
 *
 * Each file returns a PHP array (programme details, research tables, FAQs,
 * ...), so editors change copy without touching templates or controllers.
 */
class ContentRepository
{
    /**
     * @var array<string, array<mixed>>
     */
    private array $loaded = [];

    /**
     * @return array<mixed>
     */
    public function get(string $name): array
    {
        if (! $this->has($name)) {
            throw new InvalidArgumentException("Content file [{$name}] does not exist.");
        }

        return $this->loaded[$name] ??= require $this->path($name);
    }

    /**
     * The file's top-level entries keyed in camelCase, ready to pass to a view.
     *
     * @return array<string, mixed>
     */
    public function viewData(string $name): array
    {
        $data = [];

        foreach ($this->get($name) as $key => $value) {
            $data[Str::camel((string) $key)] = $value;
        }

        return $data;
    }

    public function has(string $name): bool
    {
        return preg_match('#^[a-z0-9][a-z0-9.\-/]*$#', $name) === 1
            && ! str_contains($name, '..')
            && is_file($this->path($name));
    }

    private function path(string $name): string
    {
        return resource_path('data/'.$name.'.php');
    }
}
