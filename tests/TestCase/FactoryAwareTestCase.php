<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\Factory\IInstantiatorFactory;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Color\Util\Instantiator;

abstract class FactoryAwareTestCase extends TestCase
{
    private static ?IInstantiatorFactory $instantiatorFactory = null;
    private static ?IConverterFactory $converterFactory = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::storeInstantiatorFactory();
        self::storeConverterFactory();

        self::setInstantiatorFactory(null);
        self::setConverterFactory(null);
    }

    private static function storeInstantiatorFactory(): void
    {
        self::$instantiatorFactory = self::getPropertyValue(Instantiator::class, 'factory');
    }

    private static function storeConverterFactory(): void
    {
        self::$converterFactory = self::getPropertyValue(Converter::class, 'factory');
    }

    private static function setInstantiatorFactory(?IInstantiatorFactory $factory): void
    {
        self::setPropertyValue(Instantiator::class, 'factory', $factory);
    }

    protected static function setConverterFactory(?IConverterFactory $factory): void
    {
        self::setPropertyValue(Converter::class, 'factory', $factory);
    }

    protected function tearDown(): void
    {
        self::rollbackInstantiatorFactory();
        self::rollbackConverterFactory();
        parent::tearDown();
    }

    private static function rollbackInstantiatorFactory(): void
    {
        self::setInstantiatorFactory(self::$instantiatorFactory);
    }

    private static function rollbackConverterFactory(): void
    {
        self::setConverterFactory(self::$converterFactory);
    }

}
