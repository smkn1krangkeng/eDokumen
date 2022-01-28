<!-- Create / Edit User Modal -->
<div class="modal fade" wire:ignore.self id="form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@if($modeEdit=='add') Add User @else Edit User @endif</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="store">
      <div class="modal-body">
            <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="states.name" placeholder="Enter Name" >
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mb-3">
                <label>Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="states.email" placeholder="Enter Email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" @if($modeEdit=='add') required @endif class="form-control @error('password') is-invalid @enderror" wire:model.defer="states.password" placeholder="Enter Password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mb-3">
                <label>Confirm Password</label>
                <input type="password" @if($modeEdit=='add') required @endif class="form-control @error('password_confirmation') is-invalid @enderror" wire:model.defer="states.password_confirmation" placeholder="Confirm Password">
                @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mb-3">
                <label>Role</label>
                <select class="form-select @error('role') is-invalid @enderror" wire:model.defer="states.role">
                    <option selected>Select Roles</option>
                    @foreach($roles as $row)
                    <option value='{{$row->name}}'>{{$row->name}}</option>
                    @endforeach
                </select>
                @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm text-light">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete User Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete({{$user_id}})">
      <div class="modal-body">
        <h5 class="text-center">Apakah anda yakin ingin menghapus :
        <br>
        <b>{{ $user_name }}</b>
        </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm text-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-sm text-light">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>