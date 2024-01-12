<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$hex8 = \AlecRabbit\Color\Hex8::fromInteger8(0xffffff11);

$hex = \AlecRabbit\Color\Hex::from($hex8);

$rgba = \AlecRabbit\Color\RGBA::from($hex8);

$rgb = \AlecRabbit\Color\RGB::from($hex8);

$hsla = \AlecRabbit\Color\HSLA::from($hex8);

$hsl = \AlecRabbit\Color\HSL::from($hex8);

dump(
    $hex8,
    $hex,
    $rgba,
    $rgb,
    $hsla,
    $hsl,
    '--------------',
    \AlecRabbit\Color\Hex8::from($hex8),
    \AlecRabbit\Color\Hex8::from($hex),
    \AlecRabbit\Color\Hex8::from($rgba),
    \AlecRabbit\Color\Hex8::from($rgb),
    \AlecRabbit\Color\Hex8::from($hsla),
    \AlecRabbit\Color\Hex8::from($hsl),
);
