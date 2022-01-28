<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('My Files Manager') }}
    </h2>
</x-slot>
@push('scripts')
<script>
    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form', event => {
        $('#form').modal('hide');
    })
</script>
<script>
    window.addEventListener('show-form-del', event => {
        $('#form-del').modal('show');
    })
</script>
<script>
    window.addEventListener('hide-form-del', event => {
        $('#form-del').modal('hide');
    })
</script>
@endpush
<div>
    @include('livewire.back.form.formmyfile-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        <div>
                        <input class="form-control mb-3" type="text" wire:model="search" placeholder="Search Category or Name..." aria-label="search">
                        <div class="table-responsive">
                            <button wire:click.prevent="add" class="btn btn-primary btn-sm mb-3 text-light">Add File</button>
                            <table class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Is Pinned</th>
                                        <th>Is Public</th>
                                        <th>By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myfile as $key=> $row)
                                    <tr>
                                        <td>{{ $key+ $myfile->firstItem() }}</td>
                                        <td>{{ $row->filecategory->name }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>@if($row->is_pinned) Yes @else No @endif</td>
                                        <td>@if($row->is_public) Yes @else No @endif</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                        <button wire:click.prevent="edit({{$row->id}})" class="btn btn-primary text-light btn-sm mb-lg-0 mb-2 me-md-1" >Edit</button>
                                        <button wire:click.prevent="remove({{$row->id}})" class="btn btn-danger btn-sm text-light mb-lg-0 mb-2 me-md-1">Delete</button>
                                        <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light mb-lg-0 mb-2 me-md-1">Download</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $myfile->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
