@extends('app')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/daterangepicker.css') }}"/>
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>{{ __('lang.edit_option', ['field' => __('lang.promo_code')]) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('promo-codes.update', ['id' => $promo->id]) }}" method="post" data-parsley-validate>
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.title') }}</label>
                            <input type="text" value="{{ $promo->title }}" name="title" id="title" class="form-control"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 position-relative">
                        <div class="form-group">
                            <label for="">{{ __('lang.promo_code') }}</label>
                            <input type="text" value="{{ $promo->code }}" name="promo_code" id="promo_code" readonly
                                   disabled
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.validity_date') }}</label>
                            <input type="text"
                                   value="{{ \Carbon\Carbon::parse($promo->validity_from)->format('m/d/Y') }}-{{ \Carbon\Carbon::parse($promo->validity_to)->format('m/d/Y') }}"
                                   name="validity_date" id="validity_date" class="form-control datepicker"
                                   required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.all_users') }}</label>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox"
                                       id="all_users" name="for_all_users"
                                       value="1" @if($promo->for_all_users) checked @endif>
                                <label class="form-check-label"></label>
                            </div>
                            <label for="">{{ __('lang.promo_codes_for_users') }}</label>
                            <select name="users[]" @if ($promo->for_all_users) disabled @endif multiple id="users" class="select2 form-control">
                                @foreach($users as $user)
                                    <option @if(in_array($user->id, $promo_users)) selected
                                            @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.is_active') }}</label>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox"
                                       id="all_users" name="is_active"
                                       value="1" @if($promo->is_active) checked @endif>
                                <label class="form-check-label"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.promo_code_type') }}</label><br>
                            <div class="row">
                                <div class="col-4">
                                    <label for="percentage">
                                        <input type="radio" id="percentage" required name="promo_code_type"
                                               value="percentage"
                                               @if ($promo->promo_code_type === 'percentage') checked @endif> {{ __('lang.percentage') }}
                                    </label>
                                    <label for="price">
                                        <input type="radio" id="price" required name="promo_code_type"
                                               value="price"
                                               @if ($promo->promo_code_type === 'price') checked @endif> {{ __('lang.price') }}
                                    </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="number" placeholder="{{ __('lang.discount_value') }}" name="value"
                                               id="value" class="form-control" min="0" required value="{{ $promo->value }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.consumption') }}</label>
                            <select class="form-control select2" required name="consumption" id="">
                                <option @if($promo->consumption === 'any') selected @endif value="any">{{ __('lang.any') }}</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option @if($promo->consumption === $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.desc') }}</label>
                            <textarea name="description" id="desc" rows="5" class="form-control" required>{{ $promo->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('lang.save') }}
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
                startDate: moment().startOf('day'),
                endDate: moment().startOf('day').add(30, 'days'),
            });

            $("#generate_code").on('click', function () {
                let code = (Math.random() + 1).toString(36).substring(6);
                $("#promo_code").val('billu_' + code);
            });

            $("#all_users").on("change", function () {
                if ($(this).is(":checked")) {
                    $("#users").attr('disabled', true);
                    $("#users").removeAttr('required');
                } else {
                    $("#users").removeAttr('disabled');
                    $("#users").attr('required', true);
                }
            })
        </script>
    @endpush
@endsection
