<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Contract\IConverterFactory;
use AlecRabbit\Color\Converter\ColorConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

class ColorConverterTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $testee = $this->getTestee();

        self::assertInstanceOf(ColorConverter::class, $testee);
    }

    private function getTestee(?IConverterFactory $factory = null): IColorConverter
    {
        return new ColorConverter($factory ?? $this->mockConverterFactory());
    }

    protected function mockConverterFactory(): MockObject&IConverterFactory
    {
        return $this->createMock(IConverterFactory::class);
    }

    #[Test]
    public function canConvertToRGB(): void
    {
        $class = RGB::class;

        $incoming = $this->mockColor();
        $result = $this->mockColor();

        $factory = $this->mockConverterFactory();

        $converter = $this->mockConverter();

        $factory
            ->expects($this->once())
            ->method('make')
            ->with($this->equalTo($class))
            ->willReturn($converter);

        $converter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($incoming))
            ->willReturn($result);

        $testee = $this->getTestee($factory);

        self::assertInstanceOf(ColorConverter::class, $testee);
        self::assertSame($result, $testee->to($class)->convert($incoming));
    }

    protected function mockColor(): MockObject&IConvertableColor
    {
        return $this->createMock(IConvertableColor::class);
    }

    protected function mockConverter(): MockObject&IConverter
    {
        return $this->createMock(IConverter::class);
    }

    #[Test]
    public function canConvertToRGBA(): void
    {
        $class = RGBA::class;

        $incoming = $this->mockColor();
        $result = $this->mockColor();

        $factory = $this->mockConverterFactory();

        $converter = $this->mockConverter();

        $factory
            ->expects($this->once())
            ->method('make')
            ->with($this->equalTo($class))
            ->willReturn($converter);

        $converter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($incoming))
            ->willReturn($result);

        $testee = $this->getTestee($factory);

        self::assertInstanceOf(ColorConverter::class, $testee);
        self::assertSame($result, $testee->to($class)->convert($incoming));
    }

    #[Test]
    public function canConvertToHex(): void
    {
        $class = Hex::class;

        $incoming = $this->mockColor();
        $result = $this->mockColor();

        $factory = $this->mockConverterFactory();

        $converter = $this->mockConverter();

        $factory
            ->expects($this->once())
            ->method('make')
            ->with($this->equalTo($class))
            ->willReturn($converter);

        $converter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($incoming))
            ->willReturn($result);

        $testee = $this->getTestee($factory);

        self::assertInstanceOf(ColorConverter::class, $testee);
        self::assertSame($result, $testee->to($class)->convert($incoming));
    }

    #[Test]
    public function canConvertToHSL(): void
    {
        $class = HSL::class;

        $incoming = $this->mockColor();
        $result = $this->mockColor();

        $factory = $this->mockConverterFactory();

        $converter = $this->mockConverter();

        $factory
            ->expects($this->once())
            ->method('make')
            ->with($this->equalTo($class))
            ->willReturn($converter);

        $converter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($incoming))
            ->willReturn($result);

        $testee = $this->getTestee($factory);

        self::assertInstanceOf(ColorConverter::class, $testee);
        self::assertSame($result, $testee->to($class)->convert($incoming));
    }

    #[Test]
    public function canConvertToHSLA(): void
    {
        $class = HSLA::class;

        $incoming = $this->mockColor();
        $result = $this->mockColor();

        $factory = $this->mockConverterFactory();

        $converter = $this->mockConverter();

        $factory
            ->expects($this->once())
            ->method('make')
            ->with($this->equalTo($class))
            ->willReturn($converter);

        $converter
            ->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($incoming))
            ->willReturn($result);

        $testee = $this->getTestee($factory);

        self::assertInstanceOf(ColorConverter::class, $testee);
        self::assertSame($result, $testee->to($class)->convert($incoming));
    }
}
