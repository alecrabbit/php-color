<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\Hex;


use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Converter\To\Hex\ToHexConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ToHexConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            [Hex::fromInteger(0), RGBA::fromRGB(0, 0, 0)],
            [Hex::fromInteger(0), RGB::fromRGB(0, 0, 0)],
            [Hex::fromInteger(0), HSL::fromString('hsl(0, 0%, 0%)')],
            [Hex::fromInteger(0), HSLA::fromString('hsla(0, 0%, 0%, 1)')],
//            [RGBA::fromRGB(0, 0, 0), RGBA::fromRGB(0, 0, 0)],
//            [RGBA::fromRGB(12, 250, 77), RGBA::fromRGB(12, 250, 77)],
//            [RGBA::fromRGB(0, 0, 0), RGB::fromRGB(0, 0, 0)],
//            [RGBA::fromRGB(0, 0, 0), HSL::fromString('hsl(0, 0%, 0%)')],
//            [RGBA::fromRGBO(0, 0, 0, 0.55), HSLA::fromString('hsla(0, 0%, 0%, 0.55)')],
//            [RGBA::fromRGB(0, 0, 0), Hex::fromInteger(0)],
//            [RGBA::fromRGB(0x22, 0x33, 0x44), Hex::fromInteger(0x223344)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToHexConverter::class, $toConverter);
    }

    private function getTesteeInstance(): IToConverter
    {
        return new ToHexConverter();
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(IHexColor $expected, IConvertableColor $incoming): void
    {
        $toConverter = $this->getTesteeInstance();

        $result = $toConverter->convert($incoming);

        self::assertEquals($expected, $result);
    }
}