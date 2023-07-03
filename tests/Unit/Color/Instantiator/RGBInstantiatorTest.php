<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class RGBInstantiatorTest extends TestCase
{
    public static function canInstantiateRGBDataProvider(): iterable
    {
        yield from [
            ['rgb(23, 0, 255)'],
            ['rgb(213, 30, 25)'],
            ['rgb(13, 230, 125)'],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
        ];
    }
    public static function canInstantiateRGBADataProvider(): iterable
    {
        yield from [
            ['rgba(0, 0, 0, 0.5)'],
            ['rgba(0, 2, 255, 1)'],
            ['rgba(255, 11, 255, 0)'],
            ['rgba(255, 11, 255, 0.1)'],
        ];
    }

    public static function supportsFormatDataProvider(): iterable
    {
        yield from [
            ['rgb(23, 0, 255)'],
            ['rgba(255, 11, 255, 0)'],
            ['rgb(213, 30, 25)'],
            ['rgba(0, 0, 0, 0.5)'],
            ['rgb(13, 230, 125)'],
            ['rgb(22, 22, 22)'],
            ['rgb(0, 0, 0)'],
            ['rgba(0, 2, 255, 1)'],
            ['rgba(255, 11, 255, 0.1)'],
        ];
    }

    public static function doesNotSupportFormatDataProvider(): iterable
    {
        yield from [
            ['#ff0000'],
            ['ff0000'],
            ['#ff0'],
            ['ff0'],
            ['slategray'],
            ['slaTeGray'],
            ['hsl(22, 100%, 50%)'],
            ['hsla(56, 100%, 50%, 1)'],
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $instantiator = $this->getTesteeInstance();

        self::assertInstanceOf(RGBInstantiator::class, $instantiator);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new RGBInstantiator();
    }

    #[Test]
    #[DataProvider('canInstantiateRGBDataProvider')]
    public function canInstantiateRGB(string $colorString): void
    {
        $instantiator = $this->getTesteeInstance();
        $color = $instantiator->fromString($colorString);
        self::assertInstanceOf(RGB::class, $color);
    }

    #[Test]
    #[DataProvider('canInstantiateRGBADataProvider')]
    public function canInstantiateRGBA(string $colorString): void
    {
        $instantiator = $this->getTesteeInstance();
        $color = $instantiator->fromString($colorString);
        self::assertInstanceOf(RGBA::class, $color);
    }

    #[Test]
    #[DataProvider('supportsFormatDataProvider')]
    public function supportsFormat(string $format): void
    {
        self::assertTrue(RGBInstantiator::isSupported($format));
    }

    #[Test]
    #[DataProvider('doesNotSupportFormatDataProvider')]
    public function doesNotSupportFormat(string $format): void
    {
        self::assertFalse(RGBInstantiator::isSupported($format));
    }
}
