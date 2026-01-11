<?php

namespace App\Addons\Faq\Services;

/**
 * Registry for FAQ display sections.
 * Usage: app('faq.sections')->register('homepage_help_center', __('theme::faq.sections.homepage'));
 */
class FaqSectionRegistry
{
    protected array $sections = [];

    public function register(string $key, string $label): self
    {
        $this->validateKey($key);
        $this->sections[$key] = $label;

        return $this;
    }

    protected function validateKey(string $key): void
    {
        if (empty($key)) {
            throw new \InvalidArgumentException('Section key cannot be empty');
        }

        if (strlen($key) > 64) {
            throw new \InvalidArgumentException('Section key cannot exceed 64 characters');
        }

        if (!preg_match('/^[a-z0-9_]+$/', $key)) {
            throw new \InvalidArgumentException(
                'Section key must contain only lowercase letters, numbers, and underscores'
            );
        }
    }

    public function registerMany(array $sections): self
    {
        foreach ($sections as $key => $label) {
            $this->register($key, $label);
        }

        return $this;
    }

    public function unregister(string $key): self
    {
        unset($this->sections[$key]);

        return $this;
    }

    public function all(): array
    {
        return $this->sections;
    }

    public function has(string $key): bool
    {
        return isset($this->sections[$key]);
    }

    public function get(string $key): ?string
    {
        return $this->sections[$key] ?? null;
    }

    public function count(): int
    {
        return count($this->sections);
    }
}
