<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Doctrine\Type;

use App\Domain\User\ValueObject\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

class PasswordType extends StringType
{
    private const TYPE = 'hashed_password';

    /**
     * @throws ConversionException
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|null
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Password) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Password::class]);
        }

        return $value->__toString();
    }

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Password|null
    {
        if (null === $value || $value instanceof Password) {
            return $value;
        }

        try {
            $hashedPassword = Password::fromHash($value);
        } catch (\Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $hashedPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}