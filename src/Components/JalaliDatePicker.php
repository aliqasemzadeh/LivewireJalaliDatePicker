<?php

namespace Aliqasemzadeh\LivewireJalaliDatePicker\Components;

use Livewire\Component;
use Carbon\Carbon;

class JalaliDatePicker extends Component
{
    // Public properties for data binding
    public $value; // The selected date value (Y/m/d format)
    public $yearInput = false; // Whether to use input or select for year
    public $defaultToday = true; // Whether to default to today's date
    public $inlineLayout = true; // Whether to display inputs in a row (true) or in columns (false)

    // Properties for the date components
    public $year;
    public $month;
    public $day;

    // Properties for the UI state
    public $monthDays = 31; // Number of days in the current month

    // Jalali calendar months
    public $jalaliMonths = [];

    /**
     * Mount the component.
     */
    public function mount($value = null, $yearInput = null, $defaultToday = null, $inlineLayout = null): void
    {
        // Load default settings from config if not provided
        $this->yearInput = $yearInput ?? config('livewire-jalali-date-picker.year_input', false);
        $this->defaultToday = $defaultToday ?? config('livewire-jalali-date-picker.default_today', true);
        $this->inlineLayout = $inlineLayout ?? config('livewire-jalali-date-picker.inline_layout', true);

        // Load months from config
        $this->jalaliMonths = config('livewire-jalali-date-picker.months', [
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
        ]);

        // Initialize with today's date if defaultToday is true and no value is provided
        if ($this->defaultToday && !$value) {
            // Get current Jalali date
            $today = $this->getCurrentJalaliDate();
            $this->year = $today['year'];
            $this->month = $today['month'];
            $this->day = $today['day'];
        } elseif ($value) {
            // Parse the provided value
            $dateParts = explode('/', $value);
            if (count($dateParts) === 3) {
                $this->year = (int)$dateParts[0];
                $this->month = (int)$dateParts[1];
                $this->day = (int)$dateParts[2];
            }
        } else {
            // Default values if no date is provided and defaultToday is false
            $this->year = 1402; // Example default year
            $this->month = 1;
            $this->day = 1;
        }

        // Update the number of days in the month
        $this->updateMonthDays();

        // Set the initial value
        $this->updateValue();
    }

    /**
     * Get the current Jalali date.
     */
    private function getCurrentJalaliDate(): array
    {
        // Convert Gregorian date to Jalali using Carbon
        $gregorianDate = Carbon::now();

        // Get Gregorian components
        $gregorianYear = $gregorianDate->year;
        $gregorianMonth = $gregorianDate->month;
        $gregorianDay = $gregorianDate->day;

        // Correct implementation of Gregorian to Jalali conversion
        $gregorianMonthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jalaliMonthDays = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        // Check if the current Gregorian year is a leap year
        $gregorianLeapYear = (($gregorianYear % 4 == 0) && ($gregorianYear % 100 != 0)) || ($gregorianYear % 400 == 0);

        // Adjust February days for leap year
        if ($gregorianLeapYear) {
            $gregorianMonthDays[1] = 29;
        }

        // Calculate the total days from the beginning of Gregorian year
        $dayOfYear = $gregorianDay;
        for ($i = 0; $i < $gregorianMonth - 1; $i++) {
            $dayOfYear += $gregorianMonthDays[$i];
        }

        // Calculate the Jalali year
        $jalaliYear = $gregorianYear - 622;
        $jalaliDayOfYear = $dayOfYear - 79;

        if ($jalaliDayOfYear <= 0) {
            // The date belongs to the previous Jalali year
            $jalaliYear--;
            $jalaliDayOfYear += 365;
            if ($this->isLeapYear($jalaliYear)) {
                $jalaliDayOfYear++;
            }
        }

        // Check if we're in the last Jalali year and if it's a leap year
        if ($jalaliDayOfYear > 365) {
            if (!$this->isLeapYear($jalaliYear) || $jalaliDayOfYear > 366) {
                $jalaliDayOfYear -= $this->isLeapYear($jalaliYear) ? 366 : 365;
                $jalaliYear++;
            }
        }

        // Calculate the Jalali month and day
        $jalaliMonth = 0;
        for ($i = 0; $i < 11; $i++) {
            if ($jalaliDayOfYear <= $jalaliMonthDays[$i]) {
                $jalaliMonth = $i + 1;
                break;
            }
            $jalaliDayOfYear -= $jalaliMonthDays[$i];
        }

        if ($jalaliMonth == 0) {
            $jalaliMonth = 12;
        }

        $jalaliDay = $jalaliDayOfYear;

        return [
            'year' => $jalaliYear,
            'month' => $jalaliMonth,
            'day' => $jalaliDay,
        ];
    }

    /**
     * Check if the current year is a leap year in the Jalali calendar.
     */
    public function isLeapYear($year): bool
    {
        // Jalali leap year calculation
        $remainder = $year % 33;
        return in_array($remainder, [1, 5, 9, 13, 17, 22, 26, 30]);
    }

    /**
     * Update the number of days in the month based on the selected month and year.
     */
    public function updateMonthDays(): void
    {
        if ($this->month <= 6) {
            $this->monthDays = 31;
        } elseif ($this->month < 12) {
            $this->monthDays = 30;
        } else { // Month is Esfand (12)
            $this->monthDays = $this->isLeapYear($this->year) ? 30 : 29;
        }

        // Ensure the selected day is valid for the new month
        if ($this->day > $this->monthDays) {
            $this->day = $this->monthDays;
        }
    }

    /**
     * Update the value when year, month, or day changes.
     */
    public function updateValue(): void
    {
        $this->value = sprintf('%04d/%02d/%02d', $this->year, $this->month, $this->day);
        $this->dispatch('date-changed', ['value' => $this->value]);
    }

    /**
     * Handle year change.
     */
    public function updatedYear(): void
    {
        $this->updateMonthDays();
        $this->updateValue();
    }

    /**
     * Handle month change.
     */
    public function updatedMonth(): void
    {
        $this->updateMonthDays();
        $this->updateValue();
    }

    /**
     * Handle day change.
     */
    public function updatedDay(): void
    {
        $this->updateValue();
    }

    /**
     * Increment the year by 10.
     */
    public function incrementYearBy10(): void
    {
        $this->year += 10;
        $this->updateMonthDays();
        $this->updateValue();
    }

    /**
     * Decrement the year by 10.
     */
    public function decrementYearBy10(): void
    {
        $this->year -= 10;
        $this->updateMonthDays();
        $this->updateValue();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire-jalali-date-picker::jalali-date-picker');
    }
}
