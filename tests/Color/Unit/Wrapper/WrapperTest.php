<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Wrapper;

use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Converter\To\ToRGBConverter;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Instantiator\RGBInstantiator;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Wrapper\Wrapper;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Traversable;

final class WrapperTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $wrapper = $this->getTesteeInstance();

        self::assertInstanceOf(Wrapper::class, $wrapper);
    }

    private function getTesteeInstance(
        string $converter = null,
        string $instantiator = null,
    ): IWrapper {
        return new Wrapper(
            instantiator: $instantiator ?? RGBInstantiator::class,
            converter: $converter ?? ToRGBConverter::class,
        );
    }

    #[Test]
    public function canGetTargets(): void
    {
        $targets = new ArrayObject([RGB::class, IRGBColor::class]);

        $wrapper = $this->getTesteeInstance(
            converter: ToRGBConverter::class,
        );

        self::assertEquals($targets, $wrapper->getTargets());
    }

    #[Test]
    public function canGetConverter(): void
    {
        $converter = ToRGBConverter::class;

        $wrapper = $this->getTesteeInstance(
            converter: $converter,
        );

        self::assertSame($converter, $wrapper->getConverterClass());
    }

    #[Test]
    public function canGetInstantiator(): void
    {
        $instantiator = RGBInstantiator::class;

        $wrapper = $this->getTesteeInstance(
            instantiator: $instantiator,
        );

        self::assertSame($instantiator, $wrapper->getInstantiatorClass());
    }

//    #[Test]
//    public function throwsIfTargetsIsEmpty(): void
//    {
//        $this->expectException(InvalidArgument::class);
//        $this->expectExceptionMessage('Targets must not be empty.');
//
//        $this->getTesteeInstance(
//            to: new ArrayObject(),
//        );
//    }


//    #[Test]
//    public function throwsIfOneOfTargetStringsIsNotAClassAndNotAnInterface(): void
//    {
//        $this->expectException(InvalidArgument::class);
//        $this->expectExceptionMessage(
//            'Target must be a class or an interface. "invalid" given.'
//        );
//
//        $this->getTesteeInstance(
//            to: new ArrayObject([RGB::class, IRGBColor::class, 'invalid']),
//        );
//    }

//    #[Test]
//    public function throwsIfOneOfTargetStringsIsNotAConvertableColorSubclass(): void
//    {
//        $this->expectException(InvalidArgument::class);
//        $this->expectExceptionMessage(
//            'Target must be a subclass of "AlecRabbit\Color\Contract\IConvertableColor". "stdClass" given.'
//        );
//
//        $this->getTesteeInstance(
//            to: new ArrayObject([IRGBColor::class, stdClass::class]),
//        );
//    }

    #[Test]
    public function throwsIfConverterStringIsNotAConverterSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Converter class must be a subclass of "AlecRabbit\Color\Contract\Converter\IToConverter". "stdClass" given.'
        );

        $this->getTesteeInstance(
            converter: stdClass::class,
        );
    }

    #[Test]
    public function throwsIfInstantiatorStringIsNotAnInstantiatorSubclass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Instantiator class must be a subclass of "AlecRabbit\Color\Contract\Instantiator\IInstantiator". "stdClass" given.'
        );

        $this->getTesteeInstance(
            instantiator: stdClass::class,
        );
    }

    #[Test]
    public function throwsIfConverterClassStringRepresentsNonExistentClass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Converter class "nonexistent" does no exist.'
        );

        $this->getTesteeInstance(
            converter: "nonexistent",
        );
    }

    #[Test]
    public function throwsIfInstantiatorClassStringRepresentsNonExistentClass(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Instantiator class "nonexistent" does no exist.'
        );

        $this->getTesteeInstance(
            instantiator: "nonexistent",
        );
    }

//    #[Test]
//    public function throwsIfOneOfTargetsIsNotAString(): void
//    {
//        $this->expectException(InvalidArgument::class);
//        $this->expectExceptionMessage('Target must be a string. "stdClass" given.');
//
//        $this->getTesteeInstance(
//            to: new ArrayObject([IRGBColor::class, new stdClass()]),
//
//        );
//    }
}
