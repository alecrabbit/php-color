<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Tests\Color\Functional\A\Override\AColorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class AColorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $color = $this->getTesteeInstance();

        self::assertInstanceOf(AColorOverride::class, $color);
    }

    private function getTesteeInstance(): IColor
    {
        return new AColorOverride();
    }

    #[Test]
    public function throwsIfUnsupportedValueProvided(): void
    {
        $this->expectException(UnsupportedValue::class);
        $this->expectExceptionMessage(
            'AlecRabbit\Tests\Color\Functional\A\Override\AColorOverride::from(): Unsupported value of type "int" provided.'
        );

        AColorOverride::from(1);
    }
}
