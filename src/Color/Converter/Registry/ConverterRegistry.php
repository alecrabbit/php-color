<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\Registry;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;

final class ConverterRegistry implements IConverterRegistry
{
    /** @var null|\ArrayObject<class-string<IToConverter>, Array<class-string<IConvertableColor>,IFromConverter|class-string<IFromConverter>>> */
    private static ?\ArrayObject $converters = null;

    /**
     * @inheritDoc
     */
    public function getFromConverter(string $toConverter, string $color): ?IFromConverter
    {
        self::assertToConverter($toConverter);
        self::assertColor($color);
        self::ensureInitialized();

        $fromConverter = self::$converters[$toConverter][$color] ?? null;
        if (is_string($fromConverter)) {
            $fromConverter = new $fromConverter();
        }
        return $fromConverter;
    }

    private static function assertToConverter(mixed $toConverter): void
    {
        match (true) {
            !is_string($toConverter) => throw new InvalidArgument(
                sprintf(
                    'Converter must be type of string. "%s" given.',
                    get_debug_type($toConverter)
                )
            ),
            !is_subclass_of($toConverter, IToConverter::class) => throw new InvalidArgument(
                sprintf(
                    'Converter must be instance of "%s". "%s" given.',
                    IToConverter::class,
                    $toConverter
                )
            ),
            default => null,
        };
    }

    private static function assertColor(mixed $color): void
    {
        match (true) {
            !is_string($color) => throw new InvalidArgument(
                sprintf(
                    'Color must be type of string. "%s" given.',
                    get_debug_type($color)
                )
            ),
            !is_subclass_of($color, IConvertableColor::class) => throw new InvalidArgument(
                sprintf(
                    'Color must be instance of "%s". "%s" given.',
                    IConvertableColor::class,
                    $color
                )
            ),
            default => null,
        };
    }

    /**
     * @inheritDoc
     */
    public static function register(string $toConverter, \Traversable $fromConverters): void
    {
        self::assertToConverter($toConverter);
        self::ensureInitialized();

        foreach ($fromConverters as $color => $fromConverter) {
            self::assertColor($color);
            self::assertFromConverter($fromConverter);
            self::$converters[$toConverter][$color] = $fromConverter;
        }
    }

    private static function ensureInitialized(): void
    {
        if (null === self::$converters) {
            self::$converters = new \ArrayObject();
        }
    }

    private static function assertFromConverter(mixed $fromConverter): void
    {
        match (true) {
            !is_string($fromConverter) => throw new InvalidArgument(
                sprintf(
                    'Converter must be type of string. "%s" given.',
                    get_debug_type($fromConverter)
                )
            ),
            !is_subclass_of($fromConverter, IFromConverter::class) => throw new InvalidArgument(
                sprintf(
                    'Converter must be instance of "%s". "%s" given.',
                    IFromConverter::class,
                    $fromConverter
                )
            ),
            default => null,
        };
    }
}
