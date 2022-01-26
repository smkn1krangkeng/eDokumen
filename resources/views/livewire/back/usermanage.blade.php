<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('User Management') }}
    </h2>
</x-slot>
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endpush
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
@include('livewire.back.formuser-modal')
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        @php
                        $no = 1;
                        @endphp
                        <input class="form-control mb-3" type="text" wire:model="search" placeholder="Search Name" aria-label="search">
                        <div class="table-responsive">
                            <button wire:click.prevent="add" class="btn btn-primary btn-sm mb-3 text-light">Add User</button>
                            <table class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $row)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->roles->pluck('name')->implode(', ') }}</td>
                                        <td>
                                        <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary text-light btn-sm mb-lg-0 mb-2 me-md-1" >Edit</button>
                                        <button wire:click.prevent="remove({{ $row->id }})" class="btn btn-danger btn-sm text-light">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
