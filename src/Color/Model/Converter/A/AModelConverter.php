<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\A;

use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\IColorModel;

abstract readonly class AModelConverter implements IModelConverter
{
    /** @var class-string<IColorDTO> */
    protected string $inputType;
    protected ICoreConverter $converter;

    public function __construct(string $type = null, ICoreConverter $converter = null)
    {
        /** @var null|class-string<IColorDTO> $type */
        $this->inputType = $type ?? static::from()->dtoType();
        $this->converter = $converter ?? static::createConverter();
    }

    public static function from(): IColorModel
    {
        return new (static::getSourceModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getSourceModelClass(): string;

    protected static function createConverter(): ICoreConverter
    {
        return new (static::getConverterClass())();
    }

    /**
     * @return class-string<ICoreConverter>
     */
    abstract protected static function getConverterClass(): string;

    public static function to(): IColorModel
    {
        return new (static::getTargetModelClass())();
    }

    /**
     * @return class-string<IColorModel>
     */
    abstract protected static function getTargetModelClass(): string;

    public function convert(IColorDTO $color): IColorDTO
    {
        return $this->converter->convert($color);
    }
}
