<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Models\Myfile;

class Otherfile extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'myfiles.updated_at';
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
        return Myfile::select(
        'myfiles.id as id',
        'filecategories.name as category_name',
        'myfiles.name as myfile_name',
        'myfiles.path as path',
        'users.name as user_name',
        'myfiles.updated_at as myfile_updated')
        ->join('users', 'myfiles.user_id', '=', 'users.id')
        ->join('filecategories', 'myfiles.filecategory_id', '=', 'filecategories.id')
        ->where('filecategories.name', 'like', '%'.$this->inpsearch.'%')
        ->orwhere('myfiles.name', 'like', '%'.$this->inpsearch.'%')
        ->orwhere('users.name', 'like', '%'.$this->inpsearch.'%')
        ->orderBy($this->sortBy,$this->sortDirection);
/*         return Myfile::with(['user','filecategory'])
        ->cari(trim($this->inpsearch)); */
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->Myfile->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
            $this->selectAll=false;
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
        //dd($this->MyfileQuery->orderby($field,$this->sortDirection));
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
    private function deletefile($pathfile){
        if(Storage::disk('local')->exists($pathfile)){
            Storage::disk('local')->delete($pathfile);
        }
    }
    public function delete()
    {
        $myfiles = Myfile::where('id',$this->myfile_id)->first();
        $this->deletefile($myfiles->path);
        $myfiles->delete();
        $this->selectPage=false;
        $this->checked = array_diff($this->checked,$this->myfile_id );
        $this->dispatchBrowserEvent('hide-form-del');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Deleted items successfully.'
        ]);
        //dd($myfile); 

    }
    public function render()
    {
        $data['myfile']=$this->Myfile;
        $data['myfilequery']=$this->MyfileQuery->get();
        $data['delsel']=Myfile::with(['user','filecategory'])->find($this->myfile_id);
        return view('livewire.back.otherfile',$data)->layout('layouts.appclear');
    }
}
