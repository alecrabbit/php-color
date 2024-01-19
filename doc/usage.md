[⬅️ to README.md](../README.md)
# Usage

> **Note** Tentative API - subject to change.

### Create "closest" color class from string

```php
$hex = Color::from('red');                        // Hex::class
$hex = Color::from('#f00');                       // Hex::class
$rgb = Color::from('rgb(255, 0, 0)');             // RGB::class
$hsl = Color::from('hsl(0, 100%, 50%)');          // HSL::class
$hsla = Color::from('hsla(0, 100%, 50%, 0.5)');   // HSLA::class
```

### Create "exact" color class from string

```php
$hex = Hex::from('rgb(255, 0, 0)');               // Hex::class
$rgb = RGB::from('hsla(0, 100%, 50%, 0.5)');      // RGB::class
```

### Convert color to another color class
```php
$hsla = Color::from('red')->to(HSLA::class);      // HSLA::class

$rgb = 
    Color::from('hsla(120, 100%, 50%, 0.5)')
    ->to(RGB::class);                                   // RGB::class

$hsl = $color->to(HSL::class);                          // HSL::class
$hsl = $color->to(IHSLColor::class);                    // HSL::class
$rgb = $color->to(RGB::class);                          // RGB::class
$hex = $color->to(Hex::class);                          // Hex::class
```
or
```php
$color = Color::from('red');                          // Hex::class

$hsl = Color::to(HSL::class)->convert($color);              // HSL::class
$hsla = Color::to(IHSLAColor::class)->convert($color);      // HSLA::class
$rgb = Color::to(RGB::class)->convert($color);              // RGB::class
$hex = Color::to(Hex8::class)->convert($color);             // Hex8::class
```
