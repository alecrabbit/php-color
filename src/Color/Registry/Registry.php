<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Registry;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\InvalidArgument;
use RuntimeException;
use Traversable;

final class Registry implements IRegistry
{
    /** @var Array<class-string<IToConverter>, Array<class-string<IColor>,IFromConverter|class-string<IFromConverter>>> */
    private static array $fromConverters = [];

    /**
     * @inheritDoc
     */
    public static function register(string $toConverter, Traversable $fromConverters): void
    {
        self::assertToConverter($toConverter);

        /**
         * @var class-string<IToConverter> $toConverter
         * @var class-string<IColor> $color
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
            !is_subclass_of($color, IColor::class) => throw new InvalidArgument(
                sprintf(
                    'Color must be instance of "%s". "%s" given.',
                    IColor::class,
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

    /** @inheritDoc */
    public static function attach(string ...$classes): void
    {
        // TODO: Implement register() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function getFromConverter(string $to, string $source): ?IFromConverter
    {
        self::assertToConverter($to);
        self::assertColor($source);

        return $this->getRefinedFromConverter($to, $source);
    }

    private function getRefinedFromConverter(string $toConverter, string $color): ?IFromConverter
    {
        /**
         * @var class-string<IToConverter> $toConverter
         * @var class-string<IColor> $color
         * @var null|IFromConverter|class-string<IFromConverter> $fromConverter
         */
        $fromConverter = self::$fromConverters[$toConverter][$color] ?? null;
        if (is_string($fromConverter)) {
            $fromConverter = new $fromConverter();
            self::$fromConverters[$toConverter][$color] = $fromConverter;
        }
        return $fromConverter;
    }

    public function getToConverter(string $target): ?IToConverter
    {
        // TODO: Implement getToConverter() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function getInstantiator(string $color): IInstantiator
    {
        // TODO: Implement getInstantiator() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function getModelConverter(IColorModel $from, IColorModel $to): IModelConverter
    {
        // TODO: Implement getModelConverter() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
