[⬅️ to README.md](../README.md)
# Usage

> **Note** Tentative API - subject to change.

### Create "closest" color class from string, resulting type is NOT guaranteed.

```php
$c = Color::from('red');                        // RGBA::class
$c = Color::from('#f00');                       // RGBA::class
$c = Color::from('rgb(255, 0, 0)');             // RGBA::class
$c = Color::from('hsl(0, 100%, 50%)');          // HSLA::class
$c = Color::from('hsla(0, 100%, 50%, 0.5)');    // HSLA::class
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
        ->to(RGB::class);                         // RGB::class

$hsl = $color->to(HSL::class);                    // HSL::class
$hsl = $color->to(IHSLColor::class);              // HSL::class
$rgb = $color->to(RGB::class);                    // RGB::class
$hex = $color->to(Hex::class);                    // Hex::class
```
or
```php
$color = Color::from('red');                      // RGBA::class

$hsl = Converter::to(HSL::class)
           ->convert($color);                     // HSL::class
$hsla = Converter::to(IHSLAColor::class)
            ->convert($color);                    // HSLA::class
$rgb = Converter::to(RGB::class)
           ->convert($color);                     // RGB::class
$hex = Converter::to(Hex8::class)
           ->convert($color);                     // Hex8::class
```
