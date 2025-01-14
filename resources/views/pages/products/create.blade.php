@extends('app')
@section('content')
    <form action="{{ route('products.store') }}" method="post" data-parsley-validate
          enctype="multipart/form-data" id="product-form">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.title') }}</label>
                                            <input type="text" value="{{ old('product_title') }}" name="product_title" id="product_title" class="form-control"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.item_code') }}</label>
                                            <input type="text" name="sku_code" id="sku_code" value="{{ old('sku_code') }}"
                                                   class="form-control @error('sku_code') is-invalid @endif"
                                                   required>
                                            @error('sku_code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.opening_qty') }}</label>
                                            <input type="text" value="{{ old('quantity') }}" name="quantity" id="quantity" class="form-control" required
                                                   data-parsley-type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.in_hand_qty') }}</label>
                                            <input type="text" name="in_hand_quantity" value="{{ old('in_hand_quantity') }}" id="in_hand_quantity"
                                                   class="form-control"
                                                   data-parsley-type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.category') }}</label>
                                            <select name="category_id" id="category_id" class="form-control" required>
                                                <option value="">{{ __('lang.select_option') }}</option>
                                                @foreach($categories as $category)
                                                    <option @if(old('category_id') == $category->id) selected @endif value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                                <option @if(old('category_id') == "0") selected @endif value="0">{{ __('lang.others') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.brand') }}</label>
                                            <select name="brand_id" id="brand_id" class="form-control" required>
                                                <option value="">{{ __('lang.select_option') }}</option>
                                                @foreach($brands as $brand)
                                                    <option @if(old('brand_id') == $brand->id) selected @endif value="{{ $brand->id }}">{{ $brand->title }}</option>
                                                @endforeach
                                                <option @if(old('brand_id') == "0") selected @endif value="0">{{ __('lang.others') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.unit') }}</label>
                                            <select name="unit_id" id="unit_id" class="form-control" required>
                                                <option value="">{{ __('lang.select_option') }}</option>
                                                @foreach($units as $unit)
                                                    <option @if(old('unit_id') == $unit->id) selected @endif value="{{ $unit->id }}">{{ $unit->unit }} ({{ $unit->prefix }}
                                                        )
                                                    </option>
                                                @endforeach
                                                <option @if(old('unit_id') == "0") selected @endif value="0">{{ __('lang.others') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.unit_value') }}</label>
                                            <input value="{{ old('unit_value') }}" type="text" name="unit_value" id="unit_value" class="form-control" @if(old('unit_id') == "0") disabled @else required @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.supplier') }}</label>
                                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                                <option value="">{{ __('lang.select_option') }}</option>
                                                @foreach($suppliers as $supplier)
                                                    <option @if(old('supplier_id') == $supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="allow_add_to_cart_when_out_of_stock"
                                                           value="1" @if(old('allow_add_to_cart_when_out_of_stock')) checked @endif
                                                           id="checkbox1" class="form-check-input">
                                                    <label
                                                        for="checkbox1">{{ __('lang.allow_products_to_sell_out_stock') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="is_everyday_essential" value="1"
                                                           id="checkbox2" class="form-check-input" @if(old('is_everyday_essential')) checked @endif>
                                                    <label
                                                        for="checkbox2">{{ __('lang.is_everyday_essential') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.cost_price') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="cost_price" value="{{ old('cost_price') }}" id="cost_price"
                                                   class="form-control" required placeholder="{{ __('lang.cost_price') }}"
                                                   data-parsley-type="number">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="cost_price_margin" value="{{ old('cost_price_margin') }}" id="cost_price_margin" placeholder="{{ __('lang.margin_price') }}"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.price') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="price" value="{{ old('price') }}" id="price" class="form-control" required
                                                   data-parsley-type="number"
                                                   placeholder="{{ __('lang.sale_price') }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="whole_sale_price" value="{{ old('whole_sale_price') }}" id="whole_sale_price"
                                                   class="form-control" required
                                                   data-parsley-type="number"
                                                   placeholder="{{ __('lang.whole_sale_price') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="apply_discount" value="1"
                                                   id="apply_discount" @if(old('apply_discount')) checked @endif
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
                                                        <option
                                                            value="percentage" @if(old('discount_type') === 'percentage') selected @endif>{{ __('lang.percentage') }}</option>
                                                        <option value="value" @if(old('discount_type') === 'value') selected @endif>{{ __('lang.value') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.discount_value') }}</label>
                                                    <input value="{{ old('discount_value') }}" type="text" name="discount_value" id="discount_value"
                                                           class="form-control" data-parsle-type="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-sm-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.short_desc') }}</label>--}}
{{--                                    <textarea class="form-control" rows="2" name="short_description"--}}
{{--                                              required></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.long_desc') }}</label>--}}
{{--                                    <textarea class="form-control" rows="2" name="long_description"--}}
{{--                                              required></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.allergy_info') }}</label>--}}
{{--                                    <textarea class="form-control" rows="2" name="allergy_info"></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-12 col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">{{ __('lang.storage_info') }}</label>--}}
{{--                                    <textarea class="form-control" rows="2" name="storage_info"></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="formFileMultiple" class="form-label">{{ __('lang.images') }}</label>
                                    <input class="form-control" type="file" id="formFileMultiple" name="images[]"
                                           multiple/>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success"><i
                                        class="bi bi-save"></i> {{ __('lang.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@push('scripts')
    <script>
        $('#unit_id').on('change', function () {
            if ($(this).val() == 0) {
                $('#unit_value').removeAttr('required');
                $('#unit_value').attr('disabled', true);
            }
        });

        let i = 1;
        let j = 0;
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
