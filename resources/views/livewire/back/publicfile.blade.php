<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Public Files') }}
    </h2>
</x-slot>
@push('scripts')
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
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        <div>
                        <input class="form-control mb-3" type="text" wire:model="search" placeholder="Search Name or By..." aria-label="search">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-rounded">
                                <thead class="table-light">
                                    <tr>
                                    <th>No</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($publicfile as $key=> $row)
                                    <tr>
                                    <td>{{ $key+ $publicfile->firstItem() }}</td>
                                        <td>{{ $row->filecategory->name }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->user->name }}</td>
                                        <td>
                                        <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light mb-lg-0 mb-2 me-md-1">Download</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $publicfile->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
