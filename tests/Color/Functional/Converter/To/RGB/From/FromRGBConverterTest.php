<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\RGB\From;


use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Converter\To\RGB\From\FromRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
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
                    self::RESULT => RGB::fromString('rgb(0, 20, 0)')
                ],
                RGBA::fromString('rgb(0, 20, 0)'),
            ],
            [
                [
                    self::RESULT => RGB::fromString('rgb(0, 0, 0)')
                ],
                Hex::fromString('rgb(0, 0, 0)'),
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
