<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Filecategory;

class Othercat extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit;
    public $category_id,$category_name,$by;

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

    public function render()
    {
        if ($this->search !== null) {
            $catUser = Filecategory::whereRelation('user', 'name', 'like', '%' . $this->search . '%')
            ->orwhere('name','like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->limitPerPage);
        }else{
            $catUser = Filecategory::latest()
            ->paginate($this->limitPerPage);
        }
        $data['myfilecat']=$catUser;
        return view('livewire.back.othercat',$data)->layout('layouts.app');
    }
}
