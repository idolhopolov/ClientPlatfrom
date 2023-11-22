<?php

declare(strict_types=1);

namespace App\Infrastructure\Common\Doctrine\Type;

use App\Domain\Film\ValueObject\Slug;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

final class SlugType extends StringType
{
    private const TYPE = 'slug';

    /**
     * @throws ConversionException
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|null
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Slug) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Slug::class]);
        }

        return $value->__toString();
    }

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Slug|null
    {
        if (null === $value || $value instanceof Slug) {
            return $value;
        }

        try {
            $encodedValue = Slug::makeFromSlug($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $encodedValue;
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
