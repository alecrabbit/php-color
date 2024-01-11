<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Builder;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\ColorException;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Builder\IChainModelConverterBuilder;
use Traversable;

final readonly class ChainModelConverterBuilder implements IChainModelConverterBuilder
{
    /** @var iterable<class-string<IModelConverter>> */
    private iterable $converters;

    /**
     * @param iterable<class-string<IModelConverter>> $converters
     */
    public function __construct(
        iterable $converters = [],
    ) {
        $this->converters = $converters;
    }

    /** @inheritDoc */
    public function create(iterable $conversionPath): IModelConverter
    {
        $converters = $this->getChainFromPath($conversionPath);

        return new class($converters) implements IModelConverter {
            public function __construct(
                private readonly iterable $converters,
            ) {
            }

            public function convert(IColorDTO $color): IColorDTO
            {
                /** @var class-string<IModelConverter> $converter */
                foreach ($this->converters as $converter) {
                    $color = (new $converter())->convert($color);
                }
                return $color;
            }

            public static function to(): IColorModel
            {
                throw new ColorException(__METHOD__ . ' Should not be called.');
            }

            public static function from(): IColorModel
            {
                throw new ColorException(__METHOD__ . ' Should not be called.');
            }
        };
    }

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return Traversable<class-string<IModelConverter>>
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
     * @return class-string<IModelConverter>
     */
    private function getConverterClass(string $prev, string $model): string
    {
        foreach ($this->converters as $converter) {
            if ($converter::from()::class === $prev && $converter::to()::class === $model) {
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
    public function useConverters(iterable $converters): IChainModelConverterBuilder
    {
        return new self($converters);
    }

    public function build(): IModelConverter
    {
        // TODO: Implement build() method.
        throw new \RuntimeException('Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function forPath(iterable $conversionPath): IChainModelConverterBuilder
    {
        // TODO: Implement forPath() method.
        throw new \RuntimeException('Not implemented.');
    }

    /**
     * @inheritDoc
     */
    public function withConverters(iterable $converters): IChainModelConverterBuilder
    {
        // TODO: Implement withConverters() method.
        throw new \RuntimeException('Not implemented.');
    }
}
