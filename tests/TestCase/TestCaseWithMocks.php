<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Color\Contract\IColorConverter;
use AlecRabbit\Color\Contract\IColorInstantiator;
use AlecRabbit\Color\Contract\IConvertableColor;
use PHPUnit\Framework\MockObject\MockObject;

class TestCaseWithMocks extends TestCase
{
    protected function mockColor(): MockObject&IConvertableColor
    {
        return $this->createMock(IConvertableColor::class);
    }

    protected function mockConverter(): MockObject&IColorConverter
    {
        return $this->createMock(IColorConverter::class);
    }
    protected function mockInstantiator(): MockObject&IColorInstantiator
    {
        return $this->createMock(IColorInstantiator::class);
    }
}
