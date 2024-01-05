<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\HSL\From;


use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Converter\To\HSL\From\FromRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class FromRGBConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            // [expected], input
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Unsupported color type "AlecRabbit\Color\HSL".',
                    ],
                ],
                HSL::fromString('hsl(0, 0%, 0%)'),
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Unsupported color type "AlecRabbit\Color\HSLA".',
                    ],
                ],
                HSLA::fromString('hsl(0, 0%, 0%)'),
            ],
            [
                [
                    self::RESULT => HSL::fromString('rgb(0, 0, 0)')
                ],
                RGB::fromString('rgb(0, 0, 0)'),
            ],
            [
                [
                    self::RESULT => HSL::fromHSL(0, 0, 0)
                ],
                Hex::fromInteger(0),
            ],
            [
                [
                    self::RESULT => HSL::fromString('hsl(175, 100%, 54%)'),
                ],
                Hex::fromInteger(0x12ffed),
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(FromRGBConverter::class, $converter);
    }

    private function getTesteeInstance(): IFromConverter
    {
        return new FromRGBConverter();
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(array $expected, IColor $input): void
    {
        $expectedException = $this->expectsException($expected);

        $converter = $this->getTesteeInstance();

        $result = $converter->convert($input);

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertEquals($expected[self::RESULT], $result);
    }
}
