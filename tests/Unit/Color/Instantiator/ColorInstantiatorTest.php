<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Instantiator;

use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator\ColorInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ColorInstantiatorTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $testee = $this->getTestee();

        self::assertInstanceOf(ColorInstantiator::class, $testee);
    }

    protected function getTestee(): IColorInstantiator
    {
        return new ColorInstantiator();
    }

    #[Test]
    public function throwsIfColorStringIsUnrecognized(): void
    {
        $exceptionClass = UnrecognizedColorString::class;
        $exceptionMessage = 'Unrecognized color string: "unrecognized".';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->fromString('unrecognized');

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }
}
