<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Myfile;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class Otherfilenew extends Component
{
    public function render()
    {
        $myfile = Myfile::orderBy('updated_at', 'desc')
        ->get();
        $data['myfile']=$myfile;
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.otherfilenew',$data)->layout('layouts.app');
    }
}
