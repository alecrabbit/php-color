<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\RGBA;


use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Converter\To\ToRGBAConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ToRGBAConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            [RGBA::fromRGB(0, 0, 0), RGBA::fromRGB(0, 0, 0)],
            [RGBA::fromRGB(12, 250, 77), RGBA::fromRGB(12, 250, 77)],
            [RGBA::fromRGB(0, 0, 0), RGB::fromRGB(0, 0, 0)],
            [RGBA::fromRGB(0, 0, 0), HSL::from('hsl(0, 0%, 0%)')],
            [RGBA::fromRGBO(0, 0, 0, 0.55), HSLA::from('hsla(0, 0%, 0%, 0.55)')],
            [RGBA::fromRGB(0, 0, 0), Hex::fromInteger(0)],
            [RGBA::fromRGB(0x22, 0x33, 0x44), Hex::fromInteger(0x223344)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToRGBAConverter::class, $toConverter);
    }

    private function getTesteeInstance(): IToConverter
    {
        return new ToRGBAConverter();
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(IRGBAColor $expected, IColor $incoming): void
    {
        $toConverter = $this->getTesteeInstance();

        $result = $toConverter->convert($incoming);

        self::assertEquals($expected, $result);
    }
}
