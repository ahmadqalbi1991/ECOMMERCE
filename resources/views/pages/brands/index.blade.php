@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.brands') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-target="#addBrand"
                       data-bs-toggle="modal">
                        <i class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.brand')]) }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="brandTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.image') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#brandTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('brands.list') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.edit-brand', function () {
                let item = $(this).data('item');
                $('#editBrand input[name="title"]').val(item.title);
                $('#editBrand input[name="id"]').val(item.id);
                $('#editBrand select[name="category_id"]').val(item.category_id);
                let image = "{{ asset('') }}" + item.image;
                $('#editBrand #img').attr('src', image);
                $('#editBrand').modal('show');
            });
        });
    </script>
@endpush
