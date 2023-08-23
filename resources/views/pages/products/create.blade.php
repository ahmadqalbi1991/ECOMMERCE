@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.add_option', ['field' => __('lang.product')]) }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('products.store') }}" method="post" data-parsley-validate
                          enctype="multipart/form-data" id="product-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.title') }}</label>
                                    <input type="text" name="product_title" id="product_title" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.item_code') }}</label>
                                    <input type="text" name="sku_code" id="sku_code" class="form-control @error('sku_code') is-invalid @endif"
                                           required>
                                    @error('sku_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.price') }}</label>
                                    <input type="text" name="price" id="price" class="form-control" required
                                           data-parsley-type="number">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.cost_price') }}</label>
                                    <input type="text" name="cost_price" id="cost_price" class="form-control" required
                                           data-parsley-type="number">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.qty') }}</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required
                                           data-parsley-type="number">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                        <option value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @endforeach
                                        <option value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit') }}</label>
                                    <select name="unit_id" id="unit_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit }} ({{ $unit->prefix }})</option>
                                        @endforeach
                                        <option value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit_value') }}</label>
                                    <input type="text" name="unit_value" id="unit_value" class="form-control" required>
                                </div>
                            </div>
{{--                            <div class="col-sm-12 col-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.product_type') }}</label><br><br>--}}
{{--                                    <input type="radio" class="btn-check" value="simple" name="product_type"--}}
{{--                                           id="success-outlined" autocomplete="off" required>--}}
{{--                                    <label class="btn btn-outline-primary"--}}
{{--                                           for="success-outlined">{{ __('lang.simple') }}</label>--}}
{{--                                    &nbsp;--}}
{{--                                    <input type="radio" class="btn-check" value="variant" name="product_type"--}}
{{--                                           id="success-outlined-1" autocomplete="off" required>--}}
{{--                                    <label class="btn btn-outline-primary"--}}
{{--                                           for="success-outlined-1">{{ __('lang.variant') }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="allow_add_to_cart_when_out_of_stock" value="1"
                                                   id="checkbox1" class="form-check-input">
                                            <label
                                                for="checkbox1">{{ __('lang.allow_products_to_sell_out_stock') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="apply_discount" value="1" id="apply_discount"
                                                   class="form-check-input">
                                            <label
                                                for="apply_discount">{{ __('lang.apply_discount') }}</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.discount_type') }}</label>
                                                    <select name="discount_type" id="discount_type"
                                                            class="form-control">
                                                        <option value="">{{ __('lang.select_option') }}</option>
                                                        <option value="percentage">{{ __('lang.percentage') }}</option>
                                                        <option value="value">{{ __('lang.value') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.discount_value') }}</label>
                                                    <input type="text" name="discount_value" id="discount_value"
                                                           class="form-control" data-parsle-type="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="is_everyday_essential" value="1"
                                                   id="checkbox2" class="form-check-input">
                                            <label
                                                for="checkbox2">{{ __('lang.is_everyday_essential') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-12 d-none" id="variant_div">--}}
{{--                                <div class="d-flex justify-content-between">--}}
{{--                                    <h4>{{ __('lang.variants') }}</h4>--}}
{{--                                    <button type="button" class="btn btn-primary" id="add-variation"><i class="bi bi-plus"></i></button>--}}
{{--                                </div>--}}
{{--                                <hr>--}}
{{--                                <div id="variations">--}}

{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.short_desc') }}</label>
                                    <textarea class="form-control textarea" rows="3" name="short_description"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.long_desc') }}</label>
                                    <textarea class="form-control textarea" rows="3" name="long_description"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.allergy_info') }}</label>
                                    <textarea class="form-control textarea" rows="3" name="allergy_info"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.storage_info') }}</label>
                                    <textarea class="form-control textarea" rows="3" name="storage_info"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="formFileMultiple" class="form-label">{{ __('lang.images') }}</label>
                                    <input class="form-control" type="file" id="formFileMultiple" name="images[]" multiple required />
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.default_image') }}</label>--}}
{{--                                    <input type="file" name="default_image" id="default_image" class="dropify" required>--}}
{{--                                </div>--}}
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success"><i
                                        class="bi bi-save"></i> {{ __('lang.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $('#unit_id').on('change', function () {
            if ($(this).val() == 0) {
                $('#unit_value').removeAttr('required');
                $('#unit_value').attr('disabled', true);
            }
        });

        let i = 1; let j =0;
        let selected_product_type = '';
        $('input[name="product_type"]').on('change', function () {
            selected_product_type = $(this).val();
            getVariations();
        });

        function getVariations() {
            if (selected_product_type === 'variant') {
                $("#variant_div").removeClass('d-none');
                $.ajax({
                    url: '{{ route("products.getVariations") }}',
                    method: "post",
                    data: {i, j},
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        $("#variations").append(res);
                    }
                })
            } else {
                $("#variant_div").addClass('d-none');
            }
        }

        $('#add-variation').on('click', function () {
            i++;
            getVariations();
        });

        $('input[name="apply_discount"]').on('change', function () {
            if ($(this).is(':checked')) {
                $('#discount-section').removeClass('d-none');
            } else {
                $('#discount-section').addClass('d-none');
                $('#discount-section').addClass('d-none');
            }
        })
    </script>
@endpush
