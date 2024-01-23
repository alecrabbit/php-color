<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Gradient\Vector;


use AlecRabbit\Color\Contract\Gradient\Vector\IVector;
use AlecRabbit\Color\Gradient\Vector\Vector;
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
            // expected, start, end, index, precision
            [1.0, 1, 1, null, 6],
            [2.0, 1, 1, 1, 6],
            [2.0, 1.0, 1, 1, 6],
            [3.0, 1.0, 1, 2, 6],
            [5.536855, 0.0123, 0.3452847, 16, 6],
            [0.000782, 0.00003, 0.000047, 16, 6],
            [0.001064, 0.00003, 0.000047, 22, 6],
            [1.0, 1, 1, null, 9],
            [2.0, 1, 1, 1, 9],
            [2.0, 1.0, 1, 1, 9],
            [3.0, 1.0, 1, 2, 9],
            [5.5368552, 0.0123, 0.3452847, 16, 9],
            [0.00078199999, 0.00003, 0.000047, 16, 10],
            [0.001064, 0.00003, 0.000047, 22, 12],
            [0.000547, 0.00003, 0.000047, 11, 12],
            [0.0005, 0.00003, 0.000047, 10, 12],
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
        null|int $precision = null,
    ): IVector {
        return new Vector(
            x: $start ?? 0,
            step: $step ?? 0,
            precision: $precision ?? 6,
        );
    }

    #[Test]
    #[DataProvider('canGetProvider')]
    public function canGet(
        float $expected,
        int|float $start,
        int|float $step,
        ?int $index = null,
        ?int $precision = null,
    ): void {
        $vector = $this->getTesteeInstance(
            start: $start,
            step: $step,
            precision: $precision,
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
