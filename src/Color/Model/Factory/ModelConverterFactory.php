<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Factory;

use AlecRabbit\Color\Contract\Model\Converter\IModelConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\ColorException;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Factory\IModelConverterFactory;
use ArrayObject;
use Traversable;

final readonly class ModelConverterFactory implements IModelConverterFactory
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
        /** @var Array<class-string<IModelConverter>> $converters */
        $converters = [];

        $prev = null;
        foreach ($conversionPath as $model) {
            if (null === $prev) {
                $prev = $model;
                continue;
            }

            $converters[] = $this->getConverterClass($prev, $model);
            $prev = $model;
        }
        return new ArrayObject($converters);
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
    public function useConverters(iterable $converters): IModelConverterFactory
    {
        return new self($converters);
    }
}
