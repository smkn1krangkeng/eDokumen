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
    public $search;
    protected $queryString = ['search'=> ['except' => ''],
                              'category'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit=false;
    public $myfile_id,$name,$is_pinned,$filecategory_id,$is_public;
    public $file,$path,$oldpath,$upload_id;
    public $category;
    public $searchcat,$resultcat;

    public function searchcat()
    {
        $this->dispatchBrowserEvent('show-form-searchcat');
        $this->dispatchBrowserEvent('hide-form');
        $this->category=null;
    }
    public function close_formsearchcat(){
        $this->dispatchBrowserEvent('hide-form-searchcat');
        $this->dispatchBrowserEvent('show-form');
    }
    public function selectcat($id)
    {
        $this->filecategory_id=$id;
        $this->dispatchBrowserEvent('hide-form-searchcat');
        $this->dispatchBrowserEvent('show-form');
    }
    private function resetCreateForm(){
        $this->name='';
        $this->is_pinned='';
        $this->filecategory_id='';
        $this->is_public='';
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
        $this->upload_id++;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $this->modeEdit=true;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->upload_id++;
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
        if(empty($this->is_pinned)){
            $this->is_pinned=false;
        }
        $this->upload_id++;
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

        $dir='myfiles/'.Auth::user()->id.'/'.$this->filecategory_id.'/';
        if(!empty($this->file)){
            $path=$this->file->store($dir);
            $this->deletefile($this->oldpath);
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
        if ($this->category !== null) {
            $this->resultcat = Filecategory::where('user_id',Auth::user()->id)
            ->where('name','like', '%' . $this->category . '%')
            ->orderBy('name')
            ->get(); 
        }else{
            $this->resultcat = Filecategory::where('user_id',Auth::user()->id)
            ->orderBy('name')
            ->get(); 
        }
        if ($this->search !== null) {
            $myfile = Myfile::whereRelation('filecategory', 'name', 'like', '%' . $this->search . '%')
            ->where('user_id',Auth::user()->id)
            ->orWhere('name','like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate($this->limitPerPage);
        }else{
            $myfile = Myfile::where('user_id',Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->paginate($this->limitPerPage);
        }
        $data['myfile']=$myfile;
        $data['cat']=Filecategory::where('user_id',Auth::user()->id)
        ->orderBy('name')
        ->get();
        return view('livewire.back.myfileman',$data)->layout('layouts.app');
    }
}
