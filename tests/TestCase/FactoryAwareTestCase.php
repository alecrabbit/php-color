<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Color\Contract\Store\IConverterStore;
use AlecRabbit\Color\Contract\Store\IInstantiatorStore;
use AlecRabbit\Color\Util\Color;

abstract class FactoryAwareTestCase extends TestCase
{
    protected const INSTANTIATOR_STORE = 'instantiatorStore';
    protected const CONVERTER_STORE = 'converterStore';

    private static ?IInstantiatorStore $instantiatorStore = null;
    private static ?IConverterStore $converterStore = null;

    protected function setUp(): void
    {
        parent::setUp();
        self::storeInstantiatorStore();
        self::storeConverterStore();

        self::setInstantiatorStore(null);
        self::setConverterStore(null);
    }

    private static function storeInstantiatorStore(): void
    {
        self::$instantiatorStore = self::getPropertyValue(Color::class, self::INSTANTIATOR_STORE);
    }

    private static function storeConverterStore(): void
    {
        self::$converterStore = self::getPropertyValue(Color::class, self::CONVERTER_STORE);
    }

    private static function setInstantiatorStore(?IInstantiatorStore $store): void
    {
        self::setPropertyValue(Color::class, self::INSTANTIATOR_STORE, $store);
    }

    protected static function setConverterStore(?IConverterStore $factory): void
    {
        self::setPropertyValue(Color::class, self::CONVERTER_STORE, $factory);
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
        self::setConverterStore(self::$converterStore);
    }

}
