<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\RGBA\From;


use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IFromConverter;
use AlecRabbit\Color\Converter\To\RGBA\From\FromHSLConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class FromHSLConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            // [expected], input
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Unsupported color type "AlecRabbit\Color\RGB".',
                    ],
                ],
                RGB::fromString('rgb(0, 0, 0)'),
            ],
            [
                [
                    self::RESULT => RGBA::fromString('rgba(0, 0, 0)')
                ],
                HSL::fromString('rgb(0, 0, 0)'),
            ],
            [
                [
                    self::RESULT => RGBA::fromString('rgba(0, 0, 0, 0.5)')
                ],
                HSLA::fromString('hsla(0, 0%, 0%, 0.5)'),
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(FromHSLConverter::class, $converter);
    }

    private function getTesteeInstance(): IFromConverter
    {
        return new FromHSLConverter();
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(array $expected, IConvertableColor $input): void
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
