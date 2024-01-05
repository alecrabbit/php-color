<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Factory;

use AlecRabbit\Color\Contract\Factory\IConverterFactory;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\Color\Unit\Factory\Override\AConvertableColorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ConverterFactoryTest extends TestCase
{
    public static function canMakeCorrespondingConverterDataProvider(): iterable
    {
        foreach (self::canMakeCorrespondingConverterDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1],
            ];
        }
    }

    private static function canMakeCorrespondingConverterDataFeeder(): iterable
    {
        yield from [
            // (resulting)converter::class, (incoming)color::class
            [To\RGB\ToRGBConverter::class, RGB::class],
            [To\RGBA\ToRGBAConverter::class, RGBA::class],
            [To\Hex\ToHexConverter::class, Hex::class],
            [To\HSL\ToHSLConverter::class, HSL::class],
            [To\HSLA\ToHSLAConverter::class, HSLA::class],
        ];
    }

    #[Test]
    public function throwsIfConverterIsUnavailable(): void
    {
        $class = AConvertableColorOverride::class;

        $this->expectException(ConverterUnavailable::class);
        $this->expectExceptionMessage(
            sprintf(
                'Converter class for "%s" is not available.',
                $class
            )
        );
        $converterFactory = self::getTestee();
        $converterFactory->make($class);
    }

    private static function getTestee(): IConverterFactory
    {
        return new ConverterFactory();
    }

    #[Test]
    public function throwsIfClassIsNotColorSubclass(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" is not a "%s" subclass.',
                $class,
                IColor::class
            )
        );
        $converterFactory = self::getTestee();
        $converterFactory->make($class);
    }

    #[Test]
    #[DataProvider('canMakeCorrespondingConverterDataProvider')]
    public function canMakeCorrespondingConverter(string $expected, string $incoming): void
    {
        $converterFactory = self::getTestee();
        $converter = $converterFactory->make($incoming);
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expected, $converter);
    }
}
