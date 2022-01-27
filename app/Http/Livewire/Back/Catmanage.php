<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Filecategory;

class Catmanage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit;
    public $states=[];
    public $category_id,$category_name,$by;

    private function resetCreateForm(){
        $this->states['name'] = '';
        $this->states['is_public'] = '';
    }
    public function remove($id)
    {
        $this->modeEdit='delete';
        $filecategory = Filecategory::with(['user'])->findOrFail($id);
        $this->category_id = $id;
        $this->category_name = $filecategory->name;
        $this->by = $filecategory->user->name;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function delete($id)
    {
        Filecategory::find($id)->delete();
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
        $filecategory = Filecategory::findOrFail($id);
        $this->category_id = $id;
        $this->states['name'] = $filecategory->name;
        $this->states['is_public'] = $filecategory->is_public;
        $this->dispatchBrowserEvent('show-form');
    }
    public function store()
    {
        Validator::make($this->states,[
            'name' => 'required',
        ])->validate();

        if(!empty($this->states['is_public'])) {
            $is_public=$this->states['is_public'];
        } else {
            $is_public=false;
        }
        Filecategory::updateOrCreate(['id' => $this->category_id], [
            'name' => $this->states['name'],
            'is_public' => $is_public,
            'user_id' => Auth::user()->id
        ]);
        $this->dispatchBrowserEvent('hide-form');       
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->category_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
    }

    public function render()
    {
        if ($this->search !== null) {
            $catUser = Filecategory::where('user_id',Auth::user()->id)
            ->where('name','like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->limitPerPage);
        }else{
            $catUser = Filecategory::where('user_id',Auth::user()->id)
            ->latest()
            ->paginate($this->limitPerPage);
        }
        $data['myfilecat']=$catUser;
        return view('livewire.back.catmanage',$data)->layout('layouts.app');
    }
}
