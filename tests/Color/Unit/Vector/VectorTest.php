<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Vector;


use AlecRabbit\Color\Contract\Vector\IVector;
use AlecRabbit\Color\Vector\Vector;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

use function is_float;
use function is_int;

final class VectorTest extends TestCase
{

    public static function canGetProvider(): iterable
    {
        yield from [
            [1, 1, 1, null],
            [2, 1, 1, 1],
            [2.0, 1.0, 1, 1],
            [3.0, 1.0, 1, 2],
            [5.5368552, 0.0123, 0.3452847, 16],
            [0.000781999999, 0.00003, 0.000047, 16],
            [0.001064, 0.00003, 0.000047, 22],
        ];
    }

    public static function canBeCreatedWithRangeDataProvider(): iterable
    {
        yield from [
            [0, 0, [0, 1]],
            [0, 1, [0, 1, 1]],
            [0, 0, [0, 1, 0]],
            [0.0, 0.0, [0.0, 1.0, 0]],
            [2.0, 0, [2.0, 1, 0]],
            [0.0, 0.01, [0.0, 1.0, 100]],
            [0.0, 1, [0.0, 22.0, 22]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $vector = $this->getTesteeInstance();

        self::assertInstanceOf(Vector::class, $vector);
    }

    private function getTesteeInstance(
        null|int|float $start = null,
        null|int|float $step = null,
    ): IVector {
        return new Vector(
            x: $start ?? 0,
            step: $step ?? 0,
        );
    }

    #[Test]
    #[DataProvider('canGetProvider')]
    public function canGet(
        int|float $expected,
        int|float $start,
        int|float $step,
        ?int $index = null,
    ): void {
        $vector = $this->getTesteeInstance(
            start: $start,
            step: $step,
        );

        $result = $vector->get($index);

        if (is_int($expected)) {
            self::assertSame($expected, $result);
        }

        if (is_float($expected)) {
            self::assertEqualsWithDelta($expected, $result, self::FLOAT_EQUALITY_DELTA);
        }
    }

    #[Test]
    #[DataProvider('canBeCreatedWithRangeDataProvider')]
    public function canBeCreatedWithRange(
        int|float $start,
        int|float $step,
        array $input,
    ): void {
        $vector = Vector::create(...$input);

        self::assertEqualsWithDelta($start, $vector->x, self::FLOAT_EQUALITY_DELTA);
        self::assertEqualsWithDelta($step, $vector->step, self::FLOAT_EQUALITY_DELTA);
    }
}
