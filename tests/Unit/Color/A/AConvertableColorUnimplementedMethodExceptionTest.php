<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Exception\UnimplementedFunctionality;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class AConvertableColorUnimplementedMethodExceptionTest extends TestCase
{
    #[Test]
    public function throwsOnMethodCallToYUV(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toYUV();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    protected function getTestee(): IConvertableColor
    {
        return new AConvertableColorOverride();
    }

    #[Test]
    public function throwsOnMethodCallToCMYK(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toCMYK();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToXYZ(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toXYZ();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToLAB(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toLAB();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToLCh(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toLCh();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToHCL(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toHCL();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToHSV(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toHSV();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToHSVA(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toHSVA();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToYIQ(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toYIQ();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }

    #[Test]
    public function throwsOnMethodCallToGrayscale(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toGrayscale();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }
    #[Test]
    public function throwsOnMethodCallToPantone(): void
    {
        $exceptionClass = UnimplementedFunctionality::class;
        $exceptionMessage = 'Method is not implemented yet.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $testee = $this->getTestee();
        $testee->toPantone();

        self::fail(
            sprintf(
                'Exception "%s" with message "%s" was not thrown.',
                $exceptionClass,
                $exceptionMessage,
            )
        );
    }
}
