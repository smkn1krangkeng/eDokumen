<!-- Create / Edit Category Modal -->
<div class="modal fade" wire:ignore.self id="form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@if($modeEdit) Edit Category @else Add Category @endif</h5>
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
            <label>Is Public  </label>
            <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="states.is_public">
                <option Selected>Please Select</option>    
                <option value='0'>No</option>
                <option value='1'>Yes</option>
            </select>
            @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

<!-- Delete Category Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Category Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete({{ $category_id }})">
      <div class="modal-body">
      <h5 class="text-center">Apakah anda yakin ingin menghapus :
        <br>
        <b>{{ $category_name }} by {{ $by }} </b>
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