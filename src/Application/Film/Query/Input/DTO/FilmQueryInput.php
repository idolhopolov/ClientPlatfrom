<?php

declare(strict_types=1);

namespace App\Application\Film\Query\Input\DTO;

class FilmQueryInput
{
    private int $random = 0;
    private bool $multipleWords = false;
    private string $firstLetter = '';

    public function getRandom(): int
    {
        return $this->random;
    }

    public function setRandom(int $random): static
    {
        $this->random = $random;
        return $this;
    }

    public function isMultipleWords(): bool
    {
        return $this->multipleWords;
    }

    public function setMultipleWords(bool $multipleWords): static
    {
        $this->multipleWords = $multipleWords;
        return $this;
    }

    public function getFirstLetter(): string
    {
        return $this->firstLetter;
    }

    public function setFirstLetter(string $firstLetter): static
    {
        if(strlen($firstLetter) > 1) {
            throw new \UnexpectedValueException();
        }

        $this->firstLetter = $firstLetter;
        return $this;
    }
}