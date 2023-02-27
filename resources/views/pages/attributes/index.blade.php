@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.product_attributes') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-target="#addAttribute"
                       data-bs-toggle="modal"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.attribute')]) }}</a>
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
                                <th>{{ __('lang.attribute') }}</th>
                                <th>{{ __('lang.options') }}</th>
                                <th>{{ __('lang.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attributes as $key => $attribute)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $attribute->attribute }}</td>
                                    <td>{{ implode(', ', $attribute->options->pluck('option')->toArray()) }}</td>
                                    <td>
                                        <a href="{{ route('attributes.edit', ['id' => $attribute->id]) }}" class="text-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('attributes.delete', ['id' => $attribute->id]) }}" class="text-danger">
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
    <div class="modal" tabindex="-1" role="dialog" id="addAttribute">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.add_option', ['field' => __('lang.attribute')]) }}</h5>
                </div>
                <form action="{{ route('attributes.store') }}" method="post" data-parsley-validate
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.attribute') }}</label>
                                    <input type="text" name="attribute" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h5>{{ __('lang.attr_options') }}</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-info btn-sm" type="button" id="add_more_option">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row" id="more_options">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" name="options[]" class="form-control"
                                                   placeholder="Option" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('lang.save') }}
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
        let i = 0;
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });

        $('#add_more_option').on('click', function () {
            i++;
            let html = '<div class="col-2" id="option_' + i + '">' +
                '<div class="form-group position-relative option_input">' +
                '<input type="text" name="options[]" class="form-control" placeholder="Option">' +
                // '<a href="javascript:void(0)" class="remove-option text-danger" data-id="' + i + '">&times;</a>' +
                '</div>' +
                '</div>';

            $('#more_options').append(html);
        });

        $(document).on('click', '.remove-option', function () {
            $('#option_' + $(this).attr('data-id')).remove();
        });


    </script>
@endpush
