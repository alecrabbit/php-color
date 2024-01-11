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
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Factory\IModelConverterFactory;
use AlecRabbit\Color\Model\Factory\ModelConverterFactory;
use ArrayObject;
use RuntimeException;
use SplQueue;
use Traversable;

final class Registry implements IRegistry
{
    /** @var Array<class-string<IToConverter>, Array<class-string<IColor>,IFromConverter|class-string<IFromConverter>>> */
    private static array $fromConverters = [];

    private static array $modelConverters = [];
    private static array $models = [];
    private static array $graph = [];

    public function __construct(
        private readonly IModelConverterFactory $modelConverterFactory = new ModelConverterFactory(),
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
//
//        dump(self::$modelConverters);
//        dump(self::$models);
//        dump(self::$graph);
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
    public function getFromConverter(string $to, string $source): ?IFromConverter
    {
        self::assertToConverter($to);
        self::assertColor($source);

        return $this->getRefinedFromConverter($to, $source);
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
//        dump($from, $to);

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

        return $this->createModelConverter($conversionPath);
//        return dump($this->createModelConverter(dump($conversionPath)));
    }

    private static function findConversionPath(string $from, string $to): ?Traversable
    {
        $visited = [];
        $queue = new SplQueue();

        $queue->enqueue([$from]);
        $visited[$from] = true;

        while (!$queue->isEmpty()) {
            $path = $queue->dequeue();
            $node = end($path);

            if ($node === $to) {
                return new ArrayObject($path);
            }

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

    protected function createModelConverter(iterable $conversionPath): IModelConverter
    {
        return $this->getModelConverterFactory()->create($conversionPath);
    }

    protected function getModelConverterFactory(): IModelConverterFactory
    {
        return $this->modelConverterFactory
            ->useConverters(new ArrayObject(self::$modelConverters))
        ;
    }
}
