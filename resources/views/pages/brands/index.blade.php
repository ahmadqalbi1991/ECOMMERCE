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
                       data-bs-toggle="modal"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.brand')]) }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-stripped" id="table1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('lang.title') }}</th>
                                <th></th>
                                <th>{{ __('lang.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($brands as $key => $brand)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $brand->title }}</td>
                                    <td>
                                        <img src="{{ asset('/' . $brand->image) }}" alt="" width="50">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" data-item="{{ json_encode($brand) }}"
                                           class="text-primary edit-brand">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a class="text-danger delete-item" href="javascript:void(0);"
                                           data-url="{{ route('brands.delete', ['id' => $brand->id]) }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
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
    <div class="modal" tabindex="-1" role="dialog" id="addBrand">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.add_option', ['field' => __('lang.brand')]) }}</h5>
                </div>
                <form action="{{ route('brands.store') }}" method="post" data-parsley-validate
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.brand') }}</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option
                                            value="">{{ __('lang.select_option', ['field' => __('lang.category')]) }}</option>
                                        @foreach($categories as $key => $category)
                                            <option
                                                value="{{ $category->id }}">{{ $key + 1 }} {{ $category->category }}</option>
                                            @if($category->sub_categories->count())
                                                @foreach($category->sub_categories as $key1 => $category)
                                                    <option
                                                        value="{{ $category->id }}">{{ $key + 1 }}
                                                        .{{ $key1 + 1 }} {{ $category->category }}</option>
                                                    @if($category->sub_categories->count())
                                                        @foreach($category->sub_categories as $key2 => $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $key + 1 }}
                                                                .{{ $key1 + 1 }}
                                                                .{{ $key2 + 1 }} {{ $category->category }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.image') }}</label>
                                    <input type="file" name="image" class="dropify" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i
                                class="bi bi-save"></i> {{ __('lang.add_option', ['field' => __('lang.brand')]) }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="editBrand">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.edit_option', ['field' => __('lang.brand')]) }}</h5>
                </div>
                <form action="{{ route('brands.update') }}" method="post" data-parsley-validate
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.brand') }}</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option
                                            value="">{{ __('lang.select_option', ['field' => __('lang.category')]) }}</option>
                                        @foreach($categories as $key => $category)
                                            <option
                                                value="{{ $category->id }}">{{ $key + 1 }} {{ $category->category }}</option>
                                            @if($category->sub_categories->count())
                                                @foreach($category->sub_categories as $key1 => $category)
                                                    <option
                                                        value="{{ $category->id }}">{{ $key + 1 }}
                                                        .{{ $key1 + 1 }} {{ $category->category }}</option>
                                                    @if($category->sub_categories->count())
                                                        @foreach($category->sub_categories as $key2 => $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $key + 1 }}
                                                                .{{ $key1 + 1 }}
                                                                .{{ $key2 + 1 }} {{ $category->category }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.image') }}</label>
                                    <input type="file" name="image" class="dropify">
                                </div>
                                <div class="img-logo">
                                    <img src="" style="width: 100%" alt="brand" id="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i
                                class="bi bi-save"></i> {{ __('lang.edit_option', ['field' => __('lang.brand')]) }}
                        </button>
                        <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });

        $('.edit-brand').on('click', function () {
            let item = $(this).data('item');
            $('#editBrand input[name="title"]').val(item.title);
            $('#editBrand input[name="id"]').val(item.id);
            $('#editBrand select[name="category_id"]').val(item.category_id);
            let image = "{{ asset('') }}" + item.image;
            $('#editBrand #img').attr('src', image);
            $('#editBrand').modal('show');
        });
    </script>
@endpush
