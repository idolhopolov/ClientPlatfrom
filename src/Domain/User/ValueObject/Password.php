<?php

namespace App\Domain\User\ValueObject;

class Password
{
    public const COST = 12;

    private function __construct(private readonly string $hashedPassword)
    {
    }

    public static function encode(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function match(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {

        if(strlen($plainPassword) < 3)
        {
            throw new \UnexpectedValueException('Invalid content value');
        }

        /** @var string|bool|null $hashedPassword */
        $hashedPassword = \password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (\is_bool($hashedPassword)) {
            throw new \RuntimeException('Server error hashing password');
        }

        return (string) $hashedPassword;
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}