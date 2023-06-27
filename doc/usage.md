[⬅️ to README.md](../README.md)
# Usage

> **Note** Tentative API - subject to change.

```php

$color = Color::fromString('red');

$hsl = Converter::to(HSL::class)->convert($color);
$rgb = Converter::to(RGB::class)->convert($color);
$hex = Converter::to(Hex::class)->convert($color);
 // or
$hsl = $color->to(HSL::class);
$rgb = $color->to(RGB::class);
$hex = $color->to(Hex::class);

$hsla = Color::fromString('red')->to(HSLA::class);
$rgb = Color::fromString('hsla(120, 100%, 50%, 0.5)')->to(RGB::class);
```
