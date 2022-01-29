<!-- Create / Edit MyFile Modal -->
<div class="modal fade" wire:ignore.self id="form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">@if($modeEdit) Edit File @else Add File @endif</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="store">
      <div class="modal-body">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " wire:model.defer="name" placeholder="Enter Name" >
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group mb-3">
            <label>Category</label>
            <div class="input-group">
            <select class="form-select @error('filecategory_id') is-invalid @enderror" wire:model.defer="filecategory_id">
                  <option selected>Select Category</option>    
                @foreach($cat as $row)
                  <option value='{{$row->id}}'>{{$row->name}}</option>
                @endforeach
            </select>
            <button class="btn btn-secondary rounded-end" type="button">Cari</button>
            @error('filecategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-group mb-3">
            <label>Is Public  </label>
            <select class="form-select @error('is_public') is-invalid @enderror" wire:model.defer="is_public">
                <option selected>Please Select</option>  
                <option value='0'>No</option>
                <option value='1'>Yes</option>
            </select>
            @error('is_public')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group mb-3">
            <label>Is Pinned</label>
            <select class="form-select @error('is_pinned') is-invalid @enderror" wire:model.defer="is_pinned">
                <option selected>Please Select</option>     
                <option value='0'>No</option>
                <option value='1'>Yes</option>
            </select>
            @error('is_pinned')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group mb-3">
            <label>Upload File  </label>
            <input id="upload{{ $iteration }}" type="file" accept="application/pdf" class="form-control @error('file') is-invalid @enderror " wire:model.defer="file" >
            <span class="text-info"><small>Maximum file size: 10Mb</small></span>
            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

<!-- Delete MyFile Modal -->
<div class="modal fade" wire:ignore.self id="form-del" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete File Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form autocomplete="off" wire:submit.prevent="delete({{ $myfile_id }})">
      <div class="modal-body">
      <h5 class="text-center">Apakah anda yakin ingin menghapus :
        <br>
        <b>{{ $name }}</b>
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