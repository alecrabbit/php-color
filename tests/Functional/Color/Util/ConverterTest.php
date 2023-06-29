<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Util;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ConverterTest extends TestCase
{
    public static function canGetConverterFromClassStringDataProvider(): iterable
    {
        foreach (self::canGetConverterFromClassStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canGetConverterFromClassStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [ToHexConverter::class, Hex::class],
            [ToRGBAConverter::class, RGBA::class],
            [ToHSLConverter::class, HSL::class],
            [ToHSLAConverter::class, HSLA::class],
            [ToRGBConverter::class, RGB::class],
        ];
    }

//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//
//        $testee = new Converter();
//
//        self::assertInstanceOf(Converter::class, $testee);
//
//        self::fail('Exception was not thrown');
//    }

    protected function getTesteeFromClassString(string $class): IConverter
    {
        return Converter::to($class);
    }

    #[Test]
    #[DataProvider('canGetConverterFromClassStringDataProvider')]
    public function canGetConverterFromClassString(string $converterClass, string $class): void
    {
        $testee = Converter::to($class);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($converterClass, $testee);
    }
}
