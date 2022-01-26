<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\Filecategory;

class Catmanage extends Component
{
    public $viralSongs = '';
 
    public $songs = [
        'Say So',
        'The Box',
        'Laxed',
        'Savage',
        'Dance Monkey',
        'Viral',
        'Hotline Billing',
    ];

    public function render()
    {
        return view('livewire.back.catmanage')->layout('layouts.app');
    }
}
