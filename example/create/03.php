<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$hex = \AlecRabbit\Color\Hex::fromInteger(0x1122ffffff);

$hex8 = \AlecRabbit\Color\Hex8::from($hex);

$rgba = \AlecRabbit\Color\RGBA::from($hex8);

$rgb = \AlecRabbit\Color\RGB::from($hex8);

$hsla = \AlecRabbit\Color\HSLA::from($hex8);

$hsl = \AlecRabbit\Color\HSL::from($hex8);

dump(
    $hex,
    $hex8,
    $rgba,
    $rgb,
    $hsla,
    $hsl,
    \AlecRabbit\Color\Hex8::from($hex),
    \AlecRabbit\Color\Hex8::from($hex8),
    \AlecRabbit\Color\Hex8::from($rgba),
    \AlecRabbit\Color\Hex8::from($rgb),
    \AlecRabbit\Color\Hex8::from($hsla),
    \AlecRabbit\Color\Hex8::from($hsl),
);
