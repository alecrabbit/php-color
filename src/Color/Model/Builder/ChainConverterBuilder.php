<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Builder;

use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\IColorModel;
use Traversable;

use function is_subclass_of;

final class ChainConverterBuilder implements IChainConverterBuilder
{
    /** @var iterable<class-string<IColorDTOConverter>> */
    private iterable $converters;

    /** @var iterable<class-string<IColorDTOConverter>> */
    private iterable $chainConverters;

    /**
     * @param iterable<class-string<IColorDTOConverter>> $converters
     */
    public function __construct(
        iterable $converters = [],
    ) {
        $this->converters = $converters;
    }

    /** @inheritDoc */
    public function create(iterable $conversionPath): IColorDTOConverter
    {
        return self::createConverter($this->getChainFromPath($conversionPath));
    }

    protected static function createConverter(iterable $chainConverters): IColorDTOConverter
    {
        return new class($chainConverters) implements IColorDTOConverter {
            public function __construct(
                private readonly iterable $chain,
            ) {
            }

            public function convert(IColorDTO $color): IColorDTO
            {
                /** @var class-string<IColorDTOConverter> $converter */
                foreach ($this->chain as $converter) {
                    $color = (new $converter())->convert($color);
                }

                return $color;
            }
        };
    }

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return Traversable<class-string<IColorDTOConverter>>
     */
    private function getChainFromPath(iterable $conversionPath): Traversable
    {
        $prev = null;
        foreach ($conversionPath as $model) {
            if ($prev === null) {
                $prev = $model;
                continue;
            }

            yield $this->getConverterClass($prev, $model);
            $prev = $model;
        }
    }

    /**
     * @param class-string<IColorModel> $prev
     * @param class-string<IColorModel> $model
     *
     * @return class-string<IColorDTOConverter>
     */
    private function getConverterClass(string $prev, string $model): string
    {
        foreach ($this->converters as $converter) {
            if (is_subclass_of($converter, IModelConverter::class, true)
                && $converter::from()::class === $prev
                && $converter::to()::class === $model) {
                return $converter;
            }
        }

        throw new UnsupportedColorConversion(
            sprintf(
                'Converter from "%s" to "%s" not found.',
                $prev,
                $model,
            )
        );
    }

    /** @inheritDoc */
    public function useConverters(iterable $converters): IChainConverterBuilder
    {
        return new self($converters);
    }

    public function build(): IColorDTOConverter
    {
        $this->validate();
        return self::createConverter($this->chainConverters);
    }

    private function validate(): void
    {
        match (true) {
            !isset($this->chainConverters) => throw new \LogicException('Path is not provided.'),
            !isset($this->converters) => throw new \LogicException('Converters are not set.'),
            default => null,
        };
    }

    /**
     * @inheritDoc
     */
    public function forPath(iterable $conversionPath): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->chainConverters = $this->getChainFromPath($conversionPath);
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function withConverters(iterable $converters): IChainConverterBuilder
    {
        $clone = clone $this;
        $clone->converters = $converters;
        return $clone;
    }
}
