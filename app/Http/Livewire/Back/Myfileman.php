<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Myfile;
use App\Models\Filecategory;

class Myfileman extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $search,$searchcat;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit;
    public $states=[];
    public $myfile_id;

    private function resetCreateForm(){

    }
    public function remove($id)
    {
        $this->modeEdit='delete';
        $this->myfile_id = $id;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function delete($id)
    {
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        $this->resetCreateForm();
    }
    public function add()
    {
        $this->modeEdit='add';
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $this->modeEdit='edit';
        $this->myfile_id = $id;
        $this->dispatchBrowserEvent('show-form');
    }
    public function store()
    {
        dd($this->states);
        $this->dispatchBrowserEvent('hide-form');       
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->myfile_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
    }

    public function render()
    {
        if ($this->search !== null) {
            $myfile = Myfile::where('user_id',Auth::user()->id)
            ->where('name','like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->limitPerPage);
        }else{
            $myfile = Myfile::where('user_id',Auth::user()->id)
            ->latest()
            ->paginate($this->limitPerPage);
        }
        $data['myfile']=$myfile;
        $data['cat']=Filecategory::latest()
                ->where('user_id',Auth::user()->id)->get();
        return view('livewire.back.myfileman',$data)->layout('layouts.app');
    }
}
