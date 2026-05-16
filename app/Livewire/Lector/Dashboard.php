<?php

namespace App\Livewire\Lector;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.lector.dashboard')->layout('layouts.app_lector');
    }
}