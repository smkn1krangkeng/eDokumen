<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Public Files') }}
    </h2>
</x-slot>
@push('scripts')
<script>
$(document).ready(function() {
    $('#mytable').DataTable({
        "paging": true,
        "pageLength": 5,
        "lengthChange": true,
        "lengthMenu": [ [5, 10, 50, 100, -1], [5, 10, 50, 100, "All"] ],
        "searching": true,
        "ordering": true,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [
            { "orderable": false, "targets": [4] },
            { "searchable": false, "targets": [0,4] }
        ]
    });
});
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
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                        @php
                        $no=1;
                        @endphp
                        <table id="mytable" class="table table-borderless table-hover table-rounded nowrap" style="width:100%">
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
                                @foreach($publicfile as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->filecategory->name }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td>
                                    @if(file_exists(storage_path('app/'.$row->path)))
                                    <button wire:click.prevent="export({{$row->id}})" class="btn btn-success btn-sm text-light me-1">Download</button>
                                    @else
                                    <button class="btn btn-secondary btn-sm text-light me-1" disabled>Download</button>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
