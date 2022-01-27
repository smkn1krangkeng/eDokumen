<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use App\Models\User;

class Usermanage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    protected $queryString = ['search'=> ['except' => '']];
    public $limitPerPage = 2;
    public $modeEdit;
    public $user_id,$user_name;
    public $states=[];
    public $old_user_password;

    public function render()
    {
        $data['roles'] = Role::all();
        if ($this->search !== null) {
            $user = User::whereRelation('roles', 'name', 'like', '%' . $this->search . '%')
            ->orWhere('name','like', '%' . $this->search . '%')
            ->orWhere('email','like', '%' . $this->search . '%')
            ->latest()
            ->paginate($this->limitPerPage);
        }else{
            $user = User::latest()->paginate($this->limitPerPage);
        }
        $data['users']=$user;
        return view('livewire.back.usermanage',$data)->layout('layouts.app');
    }
    
    private function resetCreateForm(){
        $this->user_id = null;
        $this->states['name'] = '';
        $this->states['email'] = '';
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->states['role'] = '';
    }

    public function add()
    {
        $this->modeEdit='add';
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    
    public function remove($id)
    {
        $this->modeEdit='delete';
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->user_name = $user->name;
        $this->dispatchBrowserEvent('show-form-del');
    }

    public function store()
    {
        Validator::make($this->states,[
            'name' => 'required',
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($this->user_id),
            ],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required',
        ])->validate();
        if(!empty($this->states['password'])) {
            $password=Hash::make($this->states['password']);
        } else {
            $password=$this->old_user_password;
        }
        $user=User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->states['name'],
            'email' => $this->states['email'],
            'password' => $password,
        ]);
        $user->assignRole($this->states['role']);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->user_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
    }
    
    public function edit($id)
    {
        $this->modeEdit='edit';
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->states['name'] = $user->name;
        $this->states['email'] = $user->email;
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->old_user_password = $user->password;
        $this->states['role'] = $user->roles->pluck('name')->implode(', ');
        $this->dispatchBrowserEvent('show-form');
    }
    
    public function delete($id)
    {
        User::find($id)->delete();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        $this->resetCreateForm();
    }
}
