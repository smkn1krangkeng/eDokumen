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
    public $perhal = 2 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;
    public $myfile_id = [];

    //lifecylce hook get<namafungsi>Property
    public function getMyfileProperty(){
        return $this->MyfileQuery->paginate($this->perhal);
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
    public function updatedChecked($value){
        $this->selectPage=false;
        $this->selectAll=false;
    }
    //end lifecycle
    public function selectAll(){
        $this->selectAll=true;
        if($this->selectAll){
            $this->checked = $this->MyfileQuery->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    public function deselectAll(){
        $this->selectAll=false;
        $this->selectPage=false;
        $this->checked = [];
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
        $this->myfile_id = $this->checked;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function removesingle($id){
        $this->myfile_id = [$id];
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function delete()
    {
        dd($this->myfile_id);   
    }
    public function render()
    {
/*         $myfile=Myfile::with(['user','filecategory'])
        ->cari(trim($this->inpsearch))
        ->paginate($this->pagepaginate); */
        $data['myfile']=$this->Myfile;
        $data['myfilequery']=$this->MyfileQuery->get();
        $data['delsel']=Myfile::with(['user','filecategory'])->find($this->myfile_id);
        return view('livewire.back.otherfile',$data)->layout('layouts.appclear');
    }
}
