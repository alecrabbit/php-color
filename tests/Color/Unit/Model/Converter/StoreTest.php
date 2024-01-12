<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter;


use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Builder\IChainConverterBuilder;
use AlecRabbit\Color\Model\Contract\Converter\IStore;
use AlecRabbit\Color\Model\Converter\Store;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideOne;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideOneOverride;
use AlecRabbit\Tests\Color\Unit\Model\Converter\Override\ModelConverterOverrideTwo;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StoreTest extends TestCase
{
    private const MODEL_CONVERTERS = 'modelConverters';
    private static array $modelConverters = [];

    #[Test]
    public function canBeInstantiated(): void
    {
        $store = $this->getTesteeInstance();

        self::assertInstanceOf(Store::class, $store);
    }

    private function getTesteeInstance(
        ?\ArrayObject $models = null,
        ?\ArrayObject $graph = null,
        ?IChainConverterBuilder $modelConverterBuilder = null
    ): IStore {
        return new Store(
            models: $models ?? new \ArrayObject(),
            graph: $graph ?? new \ArrayObject(),
            modelConverterBuilder: $modelConverterBuilder ?? $this->getChainConverterBuilderMock(),
        );
    }

    protected function getChainConverterBuilderMock(): MockObject&IChainConverterBuilder
    {
        return $this->createMock(IChainConverterBuilder::class);
    }

    #[Test]
    public function canAdd(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classTwo = ModelConverterOverrideTwo::class;

        Store::add($classOne);
        Store::add($classTwo);

        $modelConverters = self::getModelConverters();

        self::assertCount(2, $modelConverters);
        self::assertContains($classOne, $modelConverters);
        self::assertContains($classTwo, $modelConverters);
    }

    protected static function getModelConverters(): array
    {
        return self::getPropertyValue(Store::class, self::MODEL_CONVERTERS);
    }

    #[Test]
    public function canAddOverrideClass(): void
    {
        $classOne = ModelConverterOverrideOne::class;
        $classOneOverride = ModelConverterOverrideOneOverride::class;

        Store::add($classOne);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($classOne, $modelConverters);

        Store::add($classOneOverride);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($classOneOverride, $modelConverters);
    }

    #[Test]
    public function addingSameConverterClassTwiceDoesNotHaveEffect(): void
    {
        $class = ModelConverterOverrideOne::class;

        Store::add($class);
        Store::add($class);

        $modelConverters = self::getModelConverters();

        self::assertCount(1, $modelConverters);
        self::assertContains($class, $modelConverters);
    }

    #[Test]
    public function throwsIfAddedClassIsNotSubclassOfModelConverter(): void
    {
        $class = \stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "stdClass" is not subclass of "AlecRabbit\Color\Model\Contract\Converter\IModelConverter".'
        );

        Store::add($class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeModelConvertersStorage();

        self::setModelConvertersStorage([]);
    }

    private static function storeModelConvertersStorage(): void
    {
        self::$modelConverters = self::getModelConverters();
    }

    private static function setModelConvertersStorage(mixed $value): void
    {
        self::setPropertyValue(Store::class, self::MODEL_CONVERTERS, $value);
    }

    protected function tearDown(): void
    {
        self::rollbackModelConvertersStorage();
        parent::tearDown();
    }

    private static function rollbackModelConvertersStorage(): void
    {
        self::setModelConvertersStorage(self::$modelConverters);
    }
}
