<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Factory;

use AlecRabbit\Color\ColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverterFactory;
use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGBConverter;
use AlecRabbit\Color\Exception\ConverterUnavailable;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Factory\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ConverterFactoryTest extends TestCase
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
            [ToRGBConverter::class, RGB::class],
            [ToRGBAConverter::class, RGBA::class],
            [ToHexConverter::class, Hex::class],
            [ToHSLConverter::class, HSL::class],
            [ToHSLAConverter::class, HSLA::class],
        ];
    }

    #[Test]
    public function throwsIfConverterIsUnavailable(): void
    {
        $class = AConvertableColorOverride::class;

        $this->expectException(ConverterUnavailable::class);
        $this->expectExceptionMessage(
            sprintf(
                'Converter for "%s" is not available.',
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
        $class = ColorConverter::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Class "%s" is not a "%s" subclass.',
                $class,
                IConvertableColor::class
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
