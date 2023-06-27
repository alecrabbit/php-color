<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Instantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class InstantiatorTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $testee = $this->getTestee();

        self::assertInstanceOf(Instantiator::class, $testee);
    }

    protected function getTestee(): IInstantiator
    {
        return new Instantiator();
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
