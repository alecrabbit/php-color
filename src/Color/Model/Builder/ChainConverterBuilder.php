<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Builder;

use AlecRabbit\Color\Contract\Model\Converter\IColorDTOConverter;
use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Builder\IChainConverterBuilder;
use RuntimeException;
use Traversable;

final readonly class ChainConverterBuilder implements IChainConverterBuilder
{
    /** @var iterable<class-string<IColorDTOConverter>> */
    private iterable $converters;

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
        $converters = $this->getChainFromPath($conversionPath);

        return new class($converters) implements IColorDTOConverter {
            public function __construct(
                private readonly iterable $converters,
            ) {
            }

            public function convert(IColorDTO $color): IColorDTO
            {
                /** @var class-string<IColorDTOConverter> $converter */
                foreach ($this->converters as $converter) {
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
            if (\is_subclass_of($converter, IModelConverter::class, true)
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
        // TODO: Implement build() method.
        throw new RuntimeException('Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function forPath(iterable $conversionPath): IChainConverterBuilder
    {
        // TODO: Implement forPath() method.
        throw new RuntimeException('Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function withConverters(iterable $converters): IChainConverterBuilder
    {
        // TODO: Implement withConverters() method.
        throw new RuntimeException('Not implemented.');
    }
}
