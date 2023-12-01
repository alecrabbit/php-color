[⬅️ to README.md](../README.md)
# Usage

> **Note** Tentative API - subject to change.

### Create "closest" color class from string

```php
$hex = Color::fromString('red');                        // Hex::class
$hex = Color::fromString('#f00');                       // Hex::class
$rgb = Color::fromString('rgb(255, 0, 0)');             // RGB::class
$hsl = Color::fromString('hsl(0, 100%, 50%)');          // HSL::class
$hsla = Color::fromString('hsla(0, 100%, 50%, 0.5)');   // HSLA::class
```

### Create "exact" color class from string

```php
$hex = Hex::fromString('rgb(255, 0, 0)');               // Hex::class
$rgb = RGB::fromString('hsla(0, 100%, 50%, 0.5)');      // RGB::class
```

### Convert color to another color class
```php
$hsla = Color::fromString('red')->to(HSLA::class);      // HSLA::class

$rgb = 
    Color::fromString('hsla(120, 100%, 50%, 0.5)')
    ->to(RGB::class);                                   // RGB::class

$hsl = $color->to(HSL::class);                          // HSL::class
$rgb = $color->to(RGB::class);                          // RGB::class
$hex = $color->to(Hex::class);                          // Hex::class
```
or
```php
$hsl = Converter::to(HSL::class)->convert($color);
$rgb = Converter::to(RGB::class)->convert($color);
$hex = Converter::to(Hex::class)->convert($color);
```
