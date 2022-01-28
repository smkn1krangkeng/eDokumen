<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Myfile;
use App\Models\Filecategory;
use Carbon\Carbon;

class Myfileman extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $search,$searchcat;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit=false;
    public $myfile_id,$name,$is_pinned,$filecategory_id,$is_public;
    public $file,$path,$oldpath,$iteration;

    private function resetCreateForm(){
        $this->name='';
        $this->is_pinned='';
        $this->filecategory_id='';
        $this->is_public='';
        $this->file=null;
        $this->iteration++;
        $this->path='';
        $this->oldpath='';
        $this->modeEdit=false;
        $this->resetErrorBag();
        $this->resetValidation();
    }
    private function deletefile($pathfile){
        if(Storage::disk('local')->exists($pathfile)){
            Storage::disk('local')->delete($pathfile);
        }
    }
    public function export($id){
        $date=Carbon::now()->format('Y-m-d');
        $myfile = Myfile::with(['user'])->findOrFail($id);
        $url=$myfile->path;
        $rename=$myfile->name." (".$myfile->user->name.") (".$date.").pdf";
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path('app/'.$url),$rename,$headers);
    }
    public function remove($id)
    {
        $myfile=Myfile::find($id);
        $this->name=$myfile->name;
        $this->oldpath=$myfile->path;
        $this->myfile_id = $id;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function delete($id)
    {
        $this->deletefile($this->oldpath);
        Myfile::find($id)->delete();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        $this->resetCreateForm();
    }
    public function add()
    {
        $this->modeEdit=false;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $this->modeEdit=true;
        $myfile = Myfile::findOrFail($id);
        $this->myfile_id=$id;
        $this->name = $myfile->name;
        $this->is_pinned = $myfile->is_pinned;
        $this->filecategory_id = $myfile->filecategory_id;
        $this->is_public = $myfile->is_public;
        $this->oldpath = $myfile->path;
        $this->dispatchBrowserEvent('show-form');
    }
    public function store()
    {
        if(!$this->modeEdit){
            $this->validate([
                'name' => 'required',
                'is_pinned' => 'required',
                'filecategory_id' => 'required',
                'is_public' => 'required',
                'file' => 'required|mimes:pdf|max:10240',
            ]);
        }else{
            $this->validate([
                'name' => 'required',
                'is_pinned' => 'required',
                'filecategory_id' => 'required',
                'is_public' => 'required',
                'file' => 'nullable|mimes:pdf|max:10240',
            ]);
        }

        $dir=Auth::user()->id.'/'.$this->filecategory_id.'/';
        if(!empty($this->file)){
            $this->deletefile($this->oldpath);
            $path=$this->file->store('myfiles/'.$dir,'local');
        }else{
            $path=$this->oldpath;
        }
        
        Myfile::updateOrCreate(['id' => $this->myfile_id], [
            'name' => $this->name,
            'is_pinned' => $this->is_pinned,
            'filecategory_id' => $this->filecategory_id,
            'is_public' => $this->is_public,
            'path' => $path,
            'user_id' => Auth::user()->id
        ]);
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
            $myfile = Myfile::whereRelation('filecategory', 'name', 'like', '%' . $this->search . '%')
            ->where('user_id',Auth::user()->id)
            ->orWhere('name','like', '%' . $this->search . '%')
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