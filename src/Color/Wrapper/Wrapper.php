<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Wrapper;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Exception\InvalidArgument;
use Traversable;

final readonly class Wrapper implements IWrapper
{
    /** @var Traversable<class-string<IColor>> */
    private Traversable $targets;

    /** @var class-string<IToConverter> */
    private string $converter;

    /** @var class-string<IInstantiator> */
    private string $instantiator;

    public function __construct(
        string $instantiator,
        string $converter,
    ) {
        self::assertConverter($converter);

        /** @var class-string<IToConverter> $converter */
        $to = $converter::getTargets();

        self::assertTo($to);
        self::assertInstantiator($instantiator);

        /** @var Traversable<class-string<IColor>> $to */
        $this->targets = $to;

        /** @var class-string<IToConverter> $converter */
        $this->converter = $converter;

        /** @var class-string<IInstantiator> $instantiator */
        $this->instantiator = $instantiator;
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

    /** @inheritDoc */
    public function getTargets(): Traversable
    {
        return $this->targets;
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
            if (!is_subclass_of($target, IColor::class)) {
                throw new InvalidArgument(
                    sprintf(
                        'Target must be a subclass of "%s". "%s" given.',
                        IColor::class,
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
    public function getConverterClass(): string
    {
        return $this->converter;
    }

    /** @inheritDoc */
    public function getInstantiatorClass(): string
    {
        return $this->instantiator;
    }
}
