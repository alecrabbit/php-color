<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Builder\ChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\Converter\IStore;
use AlecRabbit\Color\Model\Contract\IColorModel;

final class Store implements IStore
{
    private static array $modelConverters = [];
    private readonly \ArrayObject $models;
    private readonly \ArrayObject $graph;

    public function __construct(
        \ArrayObject $models = new \ArrayObject(),
        \ArrayObject $graph = new \ArrayObject(),
        private readonly IChainConverterBuilder $modelConverterBuilder = new ChainConverterBuilder(),
    ) {
        $this->models = $models;
        $this->graph = $graph;

        $this->initialize();
    }

    private function initialize(): void
    {
        $this->buildModels();
        $this->buildGraph();
    }

    private function buildModels(): void
    {
        /** @var class-string<IModelConverter> $class */
        foreach (self::$modelConverters as $class) {
            $this->models->offsetSet(self::extractFrom($class), true);
            $this->models->offsetSet(self::extractTo($class), true);
        }
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    protected static function extractFrom(string $class): string
    {
        return $class::from()::class;
    }

    /**
     * @param class-string<IModelConverter> $class
     * @return class-string<IColorModel>
     */
    protected static function extractTo(string $class): string
    {
        return $class::to()::class;
    }

    private function buildGraph(): void
    {
        /** @var class-string<IColorModel> $model */
        foreach ($this->models as $model => $_) {
            $this->graph->offsetSet($model, []);
        }

        /** @var class-string<IModelConverter> $class */
        foreach (self::$modelConverters as $class) {
            $from = self::extractFrom($class);

            /** @var array $value */
            $value = $this->graph->offsetGet($from);
            $value[] = self::extractTo($class);
            $this->graph->offsetSet($from, $value);
        }
    }

    public static function add(string ...$classes): void
    {
        foreach ($classes as $class) {
            self::assertClass($class);

            self::$modelConverters[self::createKey($class)] = $class;
        }
    }

    private static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IModelConverter::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" is not subclass of "%s".',
                    $class,
                    IModelConverter::class
                )
            );
        }
    }

    /**
     * @param class-string<IModelConverter> $class
     */
    private static function createKey(string $class): string
    {
        return self::extractFrom($class) . '::' . self::extractTo($class);
    }
}
