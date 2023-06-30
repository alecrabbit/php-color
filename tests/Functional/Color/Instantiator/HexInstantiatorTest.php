<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Instantiator;

use AlecRabbit\Color\Contract\IInstantiator;
use AlecRabbit\Color\Instantiator\HexInstantiator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HexInstantiatorTest extends TestCase
{
    #[Test]
    public function instantiator(): void
    {
        $this->assertTrue(true);
    }

    protected function getTesteeInstance(): IInstantiator
    {
        return new HexInstantiator();
    }
}
