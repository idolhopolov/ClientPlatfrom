<?php

declare(strict_types=1);

namespace App\Domain\Film\ValueObject;

use Symfony\Component\String\Slugger\AsciiSlugger;

class Slug implements \Stringable
{
    private const SEPARATOR = '|';

    private function __construct(
        private string $slug
    )
    {
    }

    public static function makeFromString(string $plaintText): static
    {
        if(str_contains($plaintText, self::SEPARATOR)) {
            throw new \UnexpectedValueException('Invalid content value');
        }

        return new self(self::slug($plaintText));
    }

    public static function makeFromSlug(string $plaintText): Slug
    {
        if(self::slug($plaintText) !== $plaintText) {
            throw new \UnexpectedValueException('Invalid content value');
        }

        return new self(self::slug($plaintText));
    }

    private static function slug(string $plaintText): string
    {
        $slugger = new AsciiSlugger();

        return $slugger->slug($plaintText, separator: self::SEPARATOR)->toString();
    }

    public function getWordCount(): int
    {
        return substr_count($this->slug, self::SEPARATOR) + 1;
    }

    public function getLetterCount(): int
    {
        return strlen($this->slug) - substr_count($this->slug, self::SEPARATOR);
    }

    public function __toString(): string
    {
        return $this->slug;
    }
}