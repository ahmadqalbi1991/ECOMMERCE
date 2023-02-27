@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.product_attributes') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('attributes.update', ['id' => $attribute->id]) }}" method="post"
                  data-parsley-validate>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.attribute') }}</label>
                            <input type="text" name="attribute" class="form-control" value="{{ $attribute->attribute }}"
                                   required>
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
                            @foreach($attribute->options as $key => $option)
                                <div class="col-2">
                                    <div class="form-group">
                                        <input type="text" name="options[{{ $key }}]" class="form-control"
                                               placeholder="Option" value="{{ $option->option }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> {{ __('lang.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let i = '{{ $key }}';
        $('#add_more_option').on('click', function () {
            i++;
            let html = '<div class="col-2" id="option_' + i + '">' +
                '<div class="form-group position-relative option_input">' +
                '<input type="text" name="options[' + i + ']" class="form-control" placeholder="Option">' +
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
