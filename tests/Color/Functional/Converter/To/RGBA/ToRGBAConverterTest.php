<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\To\RGBA;


use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Converter\To\RGBA\ToRGBAConverter;
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
            [RGBA::fromRGB(0, 0, 0), RGB::fromRGB(0, 0, 0)],
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
    public function canConvert(IRGBAColor $expected, IConvertableColor $incoming): void
    {
        $toConverter = $this->getTesteeInstance();

        $result = $toConverter->convert($incoming);

        self::assertEquals($expected, $result);
    }
}
