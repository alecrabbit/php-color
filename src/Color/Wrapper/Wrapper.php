<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Wrapper;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

final readonly class Wrapper implements IWrapper
{
    /** @var Traversable<class-string<IConvertableColor>> */
    private Traversable $targets;

    /** @var Traversable<class-string<IConvertableColor>> */
    private Traversable $sources;

    /** @var class-string<IToConverter> */
    private string $converter;

    /** @var class-string<IInstantiator> */
    private string $instantiator;

    public function __construct(
        string $instantiator,
        string $converter,
        Traversable $from,
    ) {
        self::assertConverter($converter);
        
        /** @var class-string<IToConverter> $converter */
        $to = $converter::getTargets();
        
        self::assertTo($to);
        self::assertFrom($from);
        self::assertInstantiator($instantiator);

        /** @var Traversable<class-string<IConvertableColor>> $to */
        $this->targets = $to;

        /** @var Traversable<class-string<IConvertableColor>> $from */
        $this->sources = $from;

        /** @var class-string<IToConverter> $converter */
        $this->converter = $converter;

        /** @var class-string<IInstantiator> $instantiator */
        $this->instantiator = $instantiator;
    }

    private static function assertTo(Traversable $to): void
    {
        $count = 0;
        foreach ($to as $target) {
            if (!is_string($target)) {
                throw new InvalidArgument(
                    sprintf(
                        'Target must be a string. "%s" given.',
                        get_debug_type($target)
                    )
                );
            }
            if (!interface_exists($target) && !class_exists($target)) {
                throw new InvalidArgument(
                    sprintf(
                        'Target must be a class or an interface. "%s" given.',
                        $target
                    )
                );
            }
            if (!is_subclass_of($target, IConvertableColor::class)) {
                throw new InvalidArgument(
                    sprintf(
                        'Target must be a subclass of "%s". "%s" given.',
                        IConvertableColor::class,
                        $target
                    )
                );
            }
            $count++;
        }
        if ($count === 0) {
            throw new InvalidArgument('Targets must not be empty.');
        }
    }

    private static function assertFrom(Traversable $from): void
    {
        foreach ($from as $source => $converter) {
            if (!is_string($source)) {
                throw new InvalidArgument(
                    sprintf(
                        'Source must be a string. "%s" given.',
                        get_debug_type($source)
                    )
                );
            }
            if (!is_string($converter)) {
                throw new InvalidArgument(
                    sprintf(
                        'Source converter must be a string. "%s" given.',
                        get_debug_type($converter)
                    )
                );
            }
            if (!class_exists($converter)) {
                throw new InvalidArgument(
                    sprintf(
                        'Source must be a class-string. "%s" given.',
                        $converter
                    )
                );
            }
            if (!is_subclass_of($converter, IFromConverter::class)) {
                throw new InvalidArgument(
                    sprintf(
                        'Source converter must be a subclass of "%s". "%s" given.',
                        IFromConverter::class,
                        $converter
                    )
                );
            }
            if(!is_subclass_of($source, IConvertableColor::class)) {
                throw new InvalidArgument(
                    sprintf(
                        'Source must be a subclass of "%s". "%s" given.',
                        IConvertableColor::class,
                        $source
                    )
                );
            }
        }
    }

    private static function assertConverter(string $converter): void
    {
        if (!class_exists($converter)) {
            throw new InvalidArgument(
                sprintf(
                    'Converter class "%s" does no exist.',
                    $converter
                )
            );
        }
        if (!is_subclass_of($converter, IToConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Converter class must be a subclass of "%s". "%s" given.',
                    IToConverter::class,
                    $converter,
                )
            );
        }
    }

    private static function assertInstantiator(string $instantiator): void
    {
        if (!class_exists($instantiator)) {
            throw new InvalidArgument(
                sprintf(
                    'Instantiator class "%s" does no exist.',
                    $instantiator
                )
            );
        }
        if (!is_subclass_of($instantiator, IInstantiator::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Instantiator class must be a subclass of "%s". "%s" given.',
                    IInstantiator::class,
                    $instantiator,
                )
            );
        }
    }

    /** @inheritDoc */
    public function getTargets(): Traversable
    {
        return $this->targets;
    }

    /** @inheritDoc */
    public function getConverterClass(): string
    {
        return $this->converter;
    }

    /** @inheritDoc */
    public function getInstantiatorClass(): string
    {
        return $this->instantiator;
    }

    /** @inheritDoc */
    public function getSources(): Traversable
    {
        return $this->sources;
    }
}
