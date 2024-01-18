<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Tests\Color\Functional\A\Override\AColorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AColorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $color = $this->getTesteeInstance();

        self::assertInstanceOf(AColorOverride::class, $color);
    }

    private function getTesteeInstance(
        ?IColorModel $colorModel = null
    ): IColor {
        return new AColorOverride(
            colorModel: $colorModel ?? $this->getColorModelMock()
        );
    }

    private function getColorModelMock(): MockObject&IColorModel
    {
        return $this->createMock(IColorModel::class);
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
