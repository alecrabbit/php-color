<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter\Registry;


use AlecRabbit\Color\Contract\IConverterRegistry;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\From\NoOpConverter;
use AlecRabbit\Color\Converter\Registry\ConverterRegistry;
use AlecRabbit\Color\Converter\To\RGBA\From\FromRGBConverter;
use AlecRabbit\Color\Converter\To\RGBA\ToRGBAConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class ConverterRegistryTest extends TestCase
{
    private const FROM_CONVERTERS = 'fromConverters';
    private static mixed $fromConverters = null;

    #[Test]
    public function canBeInstantiated(): void
    {
        $registry = $this->getTesteeInstance();

        self::assertInstanceOf(ConverterRegistry::class, $registry);
    }

    private function getTesteeInstance(): IConverterRegistry
    {
        return new ConverterRegistry();
    }

    #[Test]
    public function canRegisterAndRetrieve(): void
    {
        $registry = $this->getTesteeInstance();

        $converters = [
            IRGBAColor::class => NoOpConverter::class,
            RGBA::class => NoOpConverter::class,
            IRGBColor::class => FromRGBConverter::class,
            RGB::class => FromRGBConverter::class,
            IHexColor::class => FromRGBConverter::class,
            Hex::class => FromRGBConverter::class,
        ];

        ConverterRegistry::register(ToRGBAConverter::class, new ArrayObject($converters));

        self::assertInstanceOf(
            NoOpConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, IRGBAColor::class)
        );
        self::assertInstanceOf(
            NoOpConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, RGBA::class)
        );
        self::assertInstanceOf(
            FromRGBConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, IRGBColor::class)
        );
        self::assertInstanceOf(
            FromRGBConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, RGB::class)
        );
        self::assertInstanceOf(
            FromRGBConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, IHexColor::class)
        );
        self::assertInstanceOf(
            FromRGBConverter::class,
            $registry->getFromConverter(ToRGBAConverter::class, Hex::class)
        );
    }

    #[Test]
    public function throwsIfSuppliedToConverterClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Converter must be instance of "AlecRabbit\Color\Contract\IToConverter". "invalid" given.'
        );

        ConverterRegistry::register('invalid', new ArrayObject([]));
    }

    #[Test]
    public function throwsIfSuppliedColorClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Contract\IConvertableColor". "invalid" given.'
        );

        $converters = [
            'invalid' => NoOpConverter::class,
        ];

        ConverterRegistry::register(ToRGBAConverter::class, new ArrayObject($converters));
    }

    #[Test]
    public function throwsIfSuppliedFromConverterClassIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Converter must be instance of "AlecRabbit\Color\Contract\IFromConverter". "invalid" given.'
        );

        $converters = [
            IRGBAColor::class => 'invalid',
        ];

        ConverterRegistry::register(ToRGBAConverter::class, new ArrayObject($converters));
    }

    #[Test]
    public function throwsIfSuppliedFromConverterClassIsNotString(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Converter must be type of string. "int" given.'
        );

        $converters = [
            IRGBAColor::class => 1,
        ];

        ConverterRegistry::register(ToRGBAConverter::class, new ArrayObject($converters));
    }

    #[Test]
    public function throwsIfSuppliedColorClassIsNotString(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Color must be type of string. "int" given.');

        $converters = [
            1 => NoOpConverter::class,
        ];

        ConverterRegistry::register(ToRGBAConverter::class, new ArrayObject($converters));
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::storeRegistryState();
    }

    private static function storeRegistryState(): void
    {
        self::$fromConverters = self::getPropertyValue(ConverterRegistry::class, self::FROM_CONVERTERS);
    }

    protected function tearDown(): void
    {
        self::rollbackRegistryState();
        parent::tearDown();
    }

    private static function rollbackRegistryState(): void
    {
        self::setPropertyValue(ConverterRegistry::class, self::FROM_CONVERTERS, self::$fromConverters);
    }


}
