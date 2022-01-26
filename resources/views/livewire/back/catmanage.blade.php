<x-slot name="header">
    <h2 class="h4 font-weight-bold">
        {{ __('Category Management') }}
    </h2>
</x-slot>
@push('scripts')

<script>
    $(document).ready(function () {
        $('#select2').select2({
            theme: "bootstrap-5",
        });
    });

</script>

@endpush
<div>
    <div class="row justify-content-center my-5">
        <div class="col-md-12">
            <div class="card shadow bg-light">
                <div class="card-body bg-white px-5 py-3 border-bottom rounded-top">
                    <div class="mx-3 my-3">
                    <div wire:ignore>
                        <select class="form-control" id="select2">
                            <option>Select Category</option>
                            @foreach($songs as $data)
                            <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
