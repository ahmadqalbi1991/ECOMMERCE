@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.products') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('products.add') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.product')]) }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="productTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.category') }}</th>
                        <th>{{ __('lang.sku') }}</th>
                        <th>{{ __('lang.price') }}</th>
                        <th>{{ __('lang.qty') }}</th>
                        <th>{{ __('lang.unit') }}</th>
                        <th>{{ __('lang.discount') }}</th>
                        <th>{{ __('lang.discounted_price') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
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
            $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products.index') }}",
                    type: "GET",
                },
                columns: [
                    {
                        data: 'default_image',
                        name: 'default_image',
                        render: function (data) {
                            const imageUrl = `/${data}`;
                            const dummyImageUrl = "{{ asset('icon-256x256.png') }}";
                            return `<img src="${imageUrl}" alt="product_img" width="100" onerror="this.src='${dummyImageUrl}'">`;
                        }
                    },
                    { data: 'product_title', name: 'product_title' },
                    { data: 'category', name: 'category' },
                    { data: 'sku_code', name: 'sku_code' },
                    { data: 'price', name: 'price' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'unit_value', name: 'unit_value' },
                    { data: 'formatted_discount', name: 'formatted_discount' },
                    { data: 'discounted_price', name: 'discounted_price' },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            let editUrl = `{{ route('products.edit', ['slug' => ':slug']) }}`.replace(':slug', data.slug);
                            let deleteUrl = `{{ route('products.delete', ['slug' => ':slug']) }}`.replace(':slug', data.slug);
                            return `
                                <a href="${editUrl}" class="text-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" data-url="${deleteUrl}" class="text-danger delete-item">
                                    <i class="bi bi-trash"></i>
                                </a>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
