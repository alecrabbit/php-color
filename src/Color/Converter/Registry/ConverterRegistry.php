<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\Registry;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

final class ConverterRegistry implements IConverterRegistry
{
    /** @var Array<class-string<IToConverter>, Array<class-string<IConvertableColor>,IFromConverter|class-string<IFromConverter>>> */
    private static array $fromConverters = [];

    /**
     * @inheritDoc
     */
    public static function register(string $toConverter, Traversable $fromConverters): void
    {
        self::assertToConverter($toConverter);

        /**
         * @var class-string<IToConverter> $toConverter
         * @var class-string<IConvertableColor> $color
         * @var class-string<IFromConverter> $fromConverter
         */
        foreach ($fromConverters as $color => $fromConverter) {
            self::assertColor($color);
            self::assertFromConverter($fromConverter);

            self::$fromConverters[$toConverter][$color] = $fromConverter;
        }
    }

    private static function assertToConverter(string $toConverter): void
    {
        match (true) {
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

    /**
     * @inheritDoc
     */
    public function getFromConverter(string $toConverter, string $color): ?IFromConverter
    {
        self::assertToConverter($toConverter);
        self::assertColor($color);

        return $this->getRefinedFromConverter($toConverter, $color);
    }

    private function getRefinedFromConverter(string $toConverter, string $color): ?IFromConverter
    {
        /**
         * @var class-string<IToConverter> $toConverter
         * @var class-string<IConvertableColor> $color
         * @var null|IFromConverter|class-string<IFromConverter> $fromConverter
         */
        $fromConverter = self::$fromConverters[$toConverter][$color] ?? null;
        if (is_string($fromConverter)) {
            $fromConverter = new $fromConverter();
            self::$fromConverters[$toConverter][$color] = $fromConverter;
        }
        return $fromConverter;
    }
}
