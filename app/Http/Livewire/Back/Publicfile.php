<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Myfile;

class Publicfile extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;

    public function export($id){
        dd('ini export '.$id);
    }
    public function render()
    {
        if ($this->search !== null) {
            $id=Myfile::where('name','like', '%' . $this->search . '%')->pluck('id');
            $publicfile=Myfile::whereRelation('filecategory', 'is_public', true)
            ->orWhere('is_public',true)
            ->orderBy('name')
            ->get()
            ->whereIn('id', $id)
            ->paginate($this->limitPerPage);
            
            //dd($publicfile);
            
            //$publicfile=$myfile->intersect($id)->all();

        }else{
            $publicfile = Myfile::whereRelation('filecategory', 'is_public', true)
            ->orWhere('is_public',true)
            ->orderBy('updated_at', 'desc')
            ->paginate($this->limitPerPage);
        }
        $data['publicfile']=$publicfile;
        return view('livewire.back.publicfile',$data)->layout('layouts.app');
    }
}
