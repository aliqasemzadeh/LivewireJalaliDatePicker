<?php

namespace Aliqasemzadeh\LivewireJalaliDatePicker;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Aliqasemzadeh\LivewireJalaliDatePicker\Components\JalaliDatePicker;

class LivewireJalaliDatePickerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Register the component
        Livewire::component('jalali-date-picker', JalaliDatePicker::class);

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-jalali-date-picker');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/livewire-jalali-date-picker'),
        ], 'views');

        // Publish config
        $this->publishes([
            __DIR__.'/../config/livewire-jalali-date-picker.php' => config_path('livewire-jalali-date-picker.php'),
        ], 'config');

        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-jalali-date-picker.php', 'livewire-jalali-date-picker'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the config file
        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-jalali-date-picker.php', 'livewire-jalali-date-picker'
        );
    }
}
