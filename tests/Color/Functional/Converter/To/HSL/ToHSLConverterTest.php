<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\HSL;


use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Converter\To\HSL\ToHSLConverter;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ToHSLConverterTest extends TestCase
{
    public static function canConvertDataProvider(): iterable
    {
        yield from [
            [HSL::fromString('hsla(0, 0%, 0%)'), RGBA::fromRGBO(0, 0, 0, 0.55)],
//            [HSLA::fromRGB(0, 0, 0), HSLA::fromRGB(0, 0, 0)],
//            [HSLA::fromRGB(12, 250, 77), HSLA::fromRGB(12, 250, 77)],
//            [HSLA::fromRGB(0, 0, 0), RGB::fromRGB(0, 0, 0)],
//            [HSLA::fromRGB(0, 0, 0), HSL::fromString('hsl(0, 0%, 0%)')],
//            [HSLA::fromRGB(0, 0, 0), Hex::fromInteger(0)],
//            [HSLA::fromRGB(0x22, 0x33, 0x44), Hex::fromInteger(0x223344)],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $toConverter = $this->getTesteeInstance();

        self::assertInstanceOf(ToHSLConverter::class, $toConverter);
    }

    private function getTesteeInstance(): IToConverter
    {
        return new ToHSLConverter();
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(IHSLColor $expected, IColor $incoming): void
    {
        $toConverter = $this->getTesteeInstance();

        $result = $toConverter->convert($incoming);

        self::assertEquals($expected, $result);
    }
}
