<?php

namespace App\Livewire\Examples;

use Livewire\Component;

class JalaliDatePickerExample extends Component
{
    public $date;
    public $yearInputMode = false;
    public $inlineLayoutMode = true;

    public function mount(): void
    {
        $this->date = null; // Will default to today in the date picker
    }

    public function toggleYearInputMode(): void
    {
        $this->yearInputMode = !$this->yearInputMode;
    }

    public function toggleInlineLayoutMode(): void
    {
        $this->inlineLayoutMode = !$this->inlineLayoutMode;
    }

    public function save(): void
    {
        $this->dispatch('saved', ['date' => $this->date]);
    }

    public function render()
    {
        return view('examples.jalali-date-picker-example');
    }
}
