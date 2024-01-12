<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Registry;

use AlecRabbit\Color\Contract\Converter\IRegistry;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Converter\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Model\Converter\Builder\ChainConverterBuilder;
use ArrayObject;
use RuntimeException;
use SplQueue;
use Traversable;

final class Registry implements IRegistry
{
    private static array $modelConverters = [];
    private static array $models = [];
    private static array $graph = [];

    public function __construct(
        private readonly IChainConverterBuilder $modelConverterBuilder = new ChainConverterBuilder(),
    ) {
    }

    /** @inheritDoc */
    public static function attach(string ...$classes): void
    {
        /** @var IModelConverter $class */
        foreach ($classes as $class) {
            self::$modelConverters[] = $class;
            self::$models[$class::from()::class] = true;
            self::$models[$class::to()::class] = true;
        }

        self::buildGraph();
    }

    private static function buildGraph(): void
    {
        /** @var class-string<IColorModel> $model */
        foreach (self::$models as $model => $_) {
            self::$graph[$model] = [];
        }

        /** @var class-string<IModelConverter> $class */
        foreach (self::$modelConverters as $class) {
            self::$graph[$class::from()::class][] = $class::to()::class;
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

    /** @inheritDoc */
    public function getColorConverter(IColorModel $from, IColorModel $to): IColorDTOConverter
    {
        $conversionPath = self::findConversionPath($from::class, $to::class);

        if (null === $conversionPath) {
            throw new UnsupportedColorConversion(
                sprintf(
                    'No conversion path found. For "%s" to "%s".',
                    $from->dtoType(),
                    $to->dtoType(),
                )
            );
        }

        return $this->createColorConverter($conversionPath);
    }

    /**
     * @param class-string<IColorModel> $from
     * @param class-string<IColorModel> $to
     *
     * @return null|Traversable<class-string<IColorModel>>
     */
    private static function findConversionPath(string $from, string $to): ?Traversable
    {
        $visited = [];
        $queue = new SplQueue();

        $queue->enqueue([$from]);
        $visited[$from] = true;

        while (!$queue->isEmpty()) {
            /** @var Array<class-string<IColorModel>> $path */
            $path = $queue->dequeue();
            $node = end($path);

            if ($node === $to) {
                yield from $path;
            }

            /** @var class-string<IColorModel> $neighbor */
            foreach (self::$graph[$node] as $neighbor) {
                if (!isset($visited[$neighbor])) {
                    $visited[$neighbor] = true;
                    $newPath = $path;
                    $newPath[] = $neighbor;
                    $queue->enqueue($newPath);
                }
            }
        }

        return null;
    }

    /**
     * @param iterable<class-string<IColorModel>> $conversionPath
     *
     * @return IColorDTOConverter
     */
    protected function createColorConverter(iterable $conversionPath): IColorDTOConverter
    {
        return $this->modelConverterBuilder
            ->withConverters(new ArrayObject(self::$modelConverters))
            ->forPath($conversionPath)
            ->build();
    }
}
