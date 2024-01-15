<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Color\Util\Instantiator;

abstract class FactoryAwareTestCase extends TestCase
{
    protected const STORE = 'store';

    private static ?IInstantiatorStore $instantiatorStore = null;
    private static ?IConverterFactory $converterFactory = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::storeInstantiatorStore();
        self::storeConverterFactory();

        self::setInstantiatorStore(null);
        self::setConverterFactory(null);
    }

    private static function storeInstantiatorStore(): void
    {
        self::$instantiatorStore = self::getPropertyValue(Instantiator::class, self::STORE);
    }

    private static function storeConverterFactory(): void
    {
        self::$converterFactory = self::getPropertyValue(Converter::class, 'factory');
    }

    private static function setInstantiatorStore(?IInstantiatorStore $store): void
    {
        self::setPropertyValue(Instantiator::class, self::STORE, $store);
    }

    protected static function setConverterFactory(?IConverterFactory $factory): void
    {
        self::setPropertyValue(Converter::class, 'factory', $factory);
    }

    protected function tearDown(): void
    {
        self::rollbackInstantiatorStore();
        self::rollbackConverterFactory();
        parent::tearDown();
    }

    private static function rollbackInstantiatorStore(): void
    {
        self::setInstantiatorStore(self::$instantiatorStore);
    }

    private static function rollbackConverterFactory(): void
    {
        self::setConverterFactory(self::$converterFactory);
    }

}
