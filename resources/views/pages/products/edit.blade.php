@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.edit_option', ['field' => __('lang.product')]) }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('products.update', ['slug' => $product->slug]) }}" method="post"
                          data-parsley-validate
                          enctype="multipart/form-data" id="product-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.title') }}</label>
                                    <input type="text" name="product_title" id="product_title" class="form-control"
                                           required value="{{ $product->product_title }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.item_code') }}</label>
                                    <input type="text" name="sku_code" id="sku_code"
                                           class="form-control @error('sku_code') is-invalid @endif"
                                           disabled value="{{ $product->sku_code }}">
                                    @error('sku_code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.price') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="price" id="price" class="form-control" required
                                                   data-parsley-type="number" value="{{ $product->price }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="whole_sale_price" id="whole_sale_price" class="form-control" required
                                                   data-parsley-type="number" value="{{ $product->whole_sale_price }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.cost_price') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="cost_price" id="cost_price" class="form-control" required
                                                   data-parsley-type="number" value="{{ $product->cost_price }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="cost_price_margin" id="cost_price_margin" class="form-control" required
                                                   data-parsley-type="number" value="{{ $product->cost_price_margin }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.opening_qty') }}</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required
                                           data-parsley-type="number" value="{{ $product->quantity }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.in_hand_qty') }}</label>
                                    <input type="text" name="in_hand_quantity" id="in_hand_quantity" class="form-control"
                                           data-parsley-type="number" value="{{ $product->in_hand_quantity }}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.category') }}</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($categories as $category)
                                            <option @if ($product->category_id === $category->id) selected
                                                    @endif value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                        <option @if ($product->category_id == "0") selected
                                                @endif value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($brands as $brand)
                                            <option @if ($product->brand_id === $brand->id) selected
                                                    @endif value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @endforeach
                                        <option @if ($product->brand_id == "0") selected
                                                @endif value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.supplier') }}</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($suppliers as $supplier)
                                            <option @if ($product->supplier === $supplier->id) selected
                                                    @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit') }}</label>
                                    <select name="unit_id" id="unit_id" class="form-control" required>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($units as $unit)
                                            <option @if ($product->unit_id === $unit->id) selected
                                                    @endif value="{{ $unit->id }}">{{ $unit->unit }}
                                                ({{ $unit->prefix }})
                                            </option>
                                        @endforeach
                                        <option @if ($product->unit_id == "0") selected
                                                @endif value="0">{{ __('lang.others') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit_value') }}</label>
                                    <input type="text" name="unit_value" id="unit_value"
                                           value="{{ $product->unit_value }}" class="form-control" required>
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
                                                   id="checkbox1"
                                                   @if ($product->allow_add_to_cart_when_out_of_stock) checked
                                                   @endif class="form-check-input">
                                            <label
                                                for="checkbox1">{{ __('lang.allow_products_to_sell_out_stock') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="is_active" value="1"
                                                   id="checkbox2" @if ($product->is_active) checked
                                                   @endif class="form-check-input">
                                            <label
                                                for="checkbox2">{{ __('lang.is_active') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="apply_discount" value="1" id="apply_discount"
                                                   class="form-check-input"
                                                   @if ($product->apply_discount) checked @endif>
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
                                                        <option @if($product->discount_type === 'percentage') selected
                                                                @endif  value="percentage">{{ __('lang.percentage') }}</option>
                                                        <option @if($product->discount_type === 'value') selected
                                                                @endif value="value">{{ __('lang.value') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.discount_value') }}</label>
                                                    <input type="text" name="discount_value" id="discount_value"
                                                           class="form-control" data-parsle-type="number"
                                                           value="{{ $product->discount_value }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">&nbsp;</label>
                                    <br><br>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="is_everyday_essential"
                                                   @if ($product->is_everyday_essential) checked @endif value="1"
                                                   id="is_everyday_essential" class="form-check-input">
                                            <label
                                                for="is_everyday_essential">{{ __('lang.is_everyday_essential') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-12 d-none" id="variant_div">--}}
{{--                                <div class="d-flex justify-content-between">--}}
{{--                                    <h4>{{ __('lang.variants') }}</h4>--}}
{{--                                    <button type="button" class="btn btn-primary" id="add-variation"><i--}}
{{--                                            class="bi bi-plus"></i></button>--}}
{{--                                </div>--}}
{{--                                <hr>--}}
{{--                                <div id="variations">--}}

{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.short_desc') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="short_description"
                                              required>{{ $product->short_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.long_desc') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="long_description"
                                              required>{{ $product->long_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.allergy_info') }}</label>
                                    <textarea class="form-control textarea" rows="10"
                                              name="allergy_info">{{ $product->allergy_info }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.storage_info') }}</label>
                                    <textarea class="form-control textarea" rows="10"
                                              name="storage_info">{{ $product->storage_info }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="formFileMultiple" class="form-label">{{ __('lang.images') }}</label>
                                    <input class="form-control" type="file" id="formFileMultiple" name="images[]"
                                           multiple/>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="product_images">
                                    @foreach($product->images as $image)
                                        <div class="image">
                                            <img src="{{ asset('/' . $image->images) }}" alt="">
                                            <a href="{{ route('products.delete-image', ['id' => $image->id]) }}"
                                               class="text-danger"><i class="bi bi-x-circle-fill"></i></a>
                                        </div>
                                    @endforeach
                                </div>
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
