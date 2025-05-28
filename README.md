# Livewire Jalali Date Picker

A Livewire component for Jalali (Persian) date picker with AlpineJS.

## Features

- Jalali (Persian) calendar support
- Leap year calculation for Esfand (اسفند) month
- Year selection with both input field and dropdown options
- Month selection with proper Jalali month names
- Day selection that adjusts based on the selected month and year
- Inline or column layout options
- Default to today's date option
- Fully customizable through configuration

## Requirements

- PHP 8.0 or higher
- Laravel 8.0 or higher
- Livewire 2.0 or higher
- AlpineJS

## Installation

You can install the package via composer:

```bash
composer require aliqasemzadeh/livewire-jalali-date-picker
```

After installing the package, you can publish the config file with:

```bash
php artisan vendor:publish --provider="Aliqasemzadeh\LivewireJalaliDatePicker\LivewireJalaliDatePickerServiceProvider" --tag="config"
```

You can also publish the views if you need to customize them:

```bash
php artisan vendor:publish --provider="Aliqasemzadeh\LivewireJalaliDatePicker\LivewireJalaliDatePickerServiceProvider" --tag="views"
```

## Usage

In your Livewire component, you can use the JalaliDatePicker like this:

```php
<?php

namespace App\Livewire;

use Livewire\Component;

class MyForm extends Component
{
    public $date;

    public function save()
    {
        $this->validate([
            'date' => 'required|date_format:Y/m/d',
        ]);

        // Save the date...
    }

    public function render()
    {
        return view('livewire.my-form');
    }
}
```

And in your Blade view:

```html
<div>
    <label>Date</label>
    <livewire:jalali-date-picker wire:model="date" />

    <button type="button" wire:click="save">Save</button>
</div>
```

### Available Properties

The JalaliDatePicker component accepts the following properties:

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| wire:model | string | - | The property to bind the selected date to |
| year-input | boolean | false | Whether to use an input field for the year (true) or a dropdown (false) |
| default-today | boolean | true | Whether to default to today's date if no value is provided |
| inline-layout | boolean | true | Whether to display inputs in a row (true) or in columns (false) |

### Example

```html
<livewire:jalali-date-picker
    wire:model="date"
    :year-input="true"
    :default-today="true"
    :inline-layout="true"
/>
```

## Configuration

You can configure the default settings for the JalaliDatePicker component in the `config/livewire-jalali-date-picker.php` file:

```php
return [
    // Whether to use an input field for the year (true) or a dropdown (false)
    'year_input' => false,

    // Whether to default to today's date if no value is provided
    'default_today' => true,

    // Whether to display inputs in a row (true) or in columns (false)
    'inline_layout' => true,

    // Jalali calendar months
    'months' => [
        1 => 'فروردین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند',
    ],
];
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
