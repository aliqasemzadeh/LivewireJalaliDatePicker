<?php

namespace Aliqasemzadeh\LivewireJalaliDatePicker\Tests;

use Aliqasemzadeh\LivewireJalaliDatePicker\Components\JalaliDatePicker;
use Livewire\Livewire;
use Orchestra\Testbench\TestCase;
use Aliqasemzadeh\LivewireJalaliDatePicker\LivewireJalaliDatePickerServiceProvider;

class JalaliDatePickerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireJalaliDatePickerServiceProvider::class,
        ];
    }

    /** @test */
    public function it_can_render_the_component()
    {
        Livewire::test(JalaliDatePicker::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_set_a_date()
    {
        Livewire::test(JalaliDatePicker::class)
            ->set('year', 1402)
            ->set('month', 6)
            ->set('day', 15)
            ->assertSet('value', '1402/06/15');
    }

    /** @test */
    public function it_can_handle_leap_years()
    {
        // 1399 is a leap year in the Jalali calendar
        $component = Livewire::test(JalaliDatePicker::class)
            ->set('year', 1399)
            ->set('month', 12);

        // Esfand should have 30 days in a leap year
        $this->assertEquals(30, $component->get('monthDays'));

        // 1400 is not a leap year in the Jalali calendar
        $component = Livewire::test(JalaliDatePicker::class)
            ->set('year', 1400)
            ->set('month', 12);

        // Esfand should have 29 days in a non-leap year
        $this->assertEquals(29, $component->get('monthDays'));
    }

    /** @test */
    public function it_can_handle_month_days()
    {
        // First 6 months have 31 days
        $component = Livewire::test(JalaliDatePicker::class)
            ->set('month', 1);
        $this->assertEquals(31, $component->get('monthDays'));

        // Months 7-11 have 30 days
        $component = Livewire::test(JalaliDatePicker::class)
            ->set('month', 7);
        $this->assertEquals(30, $component->get('monthDays'));
    }

    /** @test */
    public function it_can_increment_and_decrement_year()
    {
        $component = Livewire::test(JalaliDatePicker::class)
            ->set('year', 1400)
            ->call('incrementYearBy10')
            ->assertSet('year', 1410)
            ->call('decrementYearBy10')
            ->assertSet('year', 1400);
    }
}
