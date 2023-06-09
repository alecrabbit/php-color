<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Tests\TestCase\TestCaseWithMocks;
use AlecRabbit\Tests\Unit\Color\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class AConvertableColorImplementedConversionMethodTest extends TestCaseWithMocks
{
    protected const CONVERTER = 'converter';
    protected static IColorConverter|null $converter = null;

    #[Test]
    public function canConvertToHex(): void
    {
        $result = $this->mockColor();
        $converter = $this->mockConverter();

        $converter
            ->expects($this->once())
            ->method('toHex')
            ->willReturn($result);

        $testee = $this->getTestee($converter);

        self::assertSame($result, $testee->toHex());
    }

    protected function getTestee(
        ?IColorConverter $converter = null,
    ): IConvertableColor {
        self::setPropertyValue(
            AConvertableColorOverride::class,
            self::CONVERTER,
            $converter ?? $this->mockConverter()
        );

        return new AConvertableColorOverride();
    }

    #[Test]
    public function canConvertToHSL(): void
    {
        $result = $this->mockColor();
        $converter = $this->mockConverter();

        $converter
            ->expects($this->once())
            ->method('toHSL')
            ->willReturn($result);

        $testee = $this->getTestee($converter);

        self::assertSame($result, $testee->toHSL());
    }

    #[Test]
    public function canConvertToHSLA(): void
    {
        $result = $this->mockColor();
        $converter = $this->mockConverter();

        $converter
            ->expects($this->once())
            ->method('toHSLA')
            ->willReturn($result);

        $testee = $this->getTestee($converter);

        self::assertSame($result, $testee->toHSLA());
    }

    #[Test]
    public function canConvertToRGB(): void
    {
        $result = $this->mockColor();
        $converter = $this->mockConverter();

        $converter
            ->expects($this->once())
            ->method('toRGB')
            ->willReturn($result);

        $testee = $this->getTestee($converter);

        self::assertSame($result, $testee->toRGB());
    }
    #[Test]
    public function canConvertToRGBA(): void
    {
        $result = $this->mockColor();
        $converter = $this->mockConverter();

        $converter
            ->expects($this->once())
            ->method('toRGBA')
            ->willReturn($result);

        $testee = $this->getTestee($converter);

        self::assertSame($result, $testee->toRGBA());
    }

    protected function setUp(): void
    {
        self::$converter = self::getPropertyValue(AConvertableColorOverride::class, self::CONVERTER);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(AConvertableColorOverride::class, self::CONVERTER, self::$converter);
    }
}
