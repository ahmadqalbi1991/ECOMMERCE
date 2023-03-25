@extends('app')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/daterangepicker.css') }}"/>
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('deals.update', ['id' => $deal->id]) }}" method="post" data-parsley-validate>
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.title') }}</label>
                            <input type="text" name="title" value="{{ $deal->title }}"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.desc') }}</label>
                            <textarea name="description" rows="5" class="form-control textarea"
                                      required>{{ $deal->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">{{ __('lang.products') }}</label>
                            <select name="products[]" id="" multiple class="form-control select2">
                                @foreach($products as $product)
                                    <option @if(in_array($product->id, $selectedProducts)) selected
                                            @endif value="{{ $product->id }}">{{ $product->product_title }}
                                        ({{ $product->sku_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.validity_date') }}</label>
                            <input type="text"
                                   value="{{ \Carbon\Carbon::parse($deal->validity_from)->format('m/d/Y') }}-{{ \Carbon\Carbon::parse($deal->validity_to)->format('m/d/Y') }}"
                                   name="validity_date"
                                   id="validity_date"
                                   class="form-control datepicker"
                                   required>
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
    @push('scripts')
        <script type="text/javascript" src="{{ asset('assets/js/moment..min.js') }}"></script>
        <script type="text/javascript"
                src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
        <script>
            $(".datepicker").daterangepicker({
                startDate: '{{ \Carbon\Carbon::parse($deal->validity_from)->format('m/d/Y') }}',
                endDate: '{{ \Carbon\Carbon::parse($deal->validity_to)->format('m/d/Y') }}',
            });
        </script>
    @endpush
@endsection
