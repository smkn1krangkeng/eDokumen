<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Myfile;

class Otherfile extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'asc';
    public $pagepaginate = 2 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;

    //lifecylce hook get<namafungsi>Property
    public function getMyfileProperty(){
        return $this->MyfileQuery->paginate($this->pagepaginate);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMyfileQueryProperty(){
        return Myfile::with(['user','filecategory'])
        ->cari(trim($this->inpsearch));
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->Myfile->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectAll($value){
        dd($value);
    }
    //lifecylce hook updated<namavariable>
    public function updatedChecked($value){
        $this->selectPage=false;
    }
    //end lifecycle
    public function selectAll(){
        $this->selectAll=true;
    }

    public function sortBy($field)
    {
        if($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        }else{
            $this->sortDirection = 'asc';
        }
        return $this->sortBy = $field;
    }
    public function is_checked($fileid){
        return in_array($fileid,$this->checked);
    }
    public function removeselection()
    {
        $myfile=Myfile::whereKey($this->checked)->get();
        dd($myfile);
        //$this->dispatchBrowserEvent('show-form-delsel');
    }
    public function render()
    {
/*         $myfile=Myfile::with(['user','filecategory'])
        ->cari(trim($this->inpsearch))
        ->paginate($this->pagepaginate); */
        $data['myfile']=$this->Myfile;
        return view('livewire.back.otherfile',$data)->layout('layouts.appclear');
    }
}
