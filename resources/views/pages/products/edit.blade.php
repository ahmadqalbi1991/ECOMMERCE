@extends('app')
@section('content')
    <form action="{{ route('products.update', ['slug' => $product->slug]) }}" method="post" data-parsley-validate
          enctype="multipart/form-data" id="product-form">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body products">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.title') }}</label>
                                            <input type="text" value="{{ $product->product_title }}"
                                                   name="product_title" id="product_title" class="form-control"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.item_code') }}</label>
                                            <input type="text" name="sku_code" id="sku_code"
                                                   value="{{ $product->sku_code }}"
                                                   class="form-control @error('sku_code') is-invalid @endif"
                                                   required>
                                            @error('sku_code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.price') }}</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="price" id="price" class="form-control"
                                                           required
                                                           data-parsley-type="number"
                                                           value="{{ $product->price }}"
                                                           placeholder="{{ __('lang.sale_price') }}">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="whole_sale_price" id="whole_sale_price"
                                                           class="form-control" required
                                                           data-parsley-type="number"
                                                           value="{{ $product->whole_sale_price }}"
                                                           placeholder="{{ __('lang.whole_sale_price') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.cost_price') }}</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" name="cost_price" id="cost_price"
                                                           class="form-control" required
                                                           value="{{ $product->cost_price }}"
                                                           data-parsley-type="number">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="cost_price_margin" id="cost_price_margin"
                                                           value="{{ $product->cost_price_margin }}"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.opening_qty') }}</label>
                                            <input type="text" name="quantity" id="quantity" class="form-control"
                                                   required
                                                   value="{{ $product->quantity }}"
                                                   data-parsley-type="number">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.in_hand_qty') }}</label>
                                            <input type="text" name="in_hand_quantity" id="in_hand_quantity"
                                                   class="form-control"
                                                   value="{{ $product->in_hand_quantity }}"
                                                   data-parsley-type="number">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.category') }}<br><br></label>
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
                                            <label for="">{{ __('lang.brand') }}<br><br></label>
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
                                                    <option @if ($product->supplier_id === $supplier->id) selected
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
                                                        ({{ $unit->prefix }}
                                                        )
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
                                            <input value="{{ $product->unit_value }}" type="text" name="unit_value"
                                                   id="unit_value" class="form-control"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="allow_add_to_cart_when_out_of_stock"
                                                           value="1"
                                                           @if ($product->allow_add_to_cart_when_out_of_stock) checked
                                                           @endif
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
                                                           @if ($product->is_everyday_essential) checked @endif
                                                           id="checkbox2" class="form-check-input">
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
                    <div class="card-body products">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="apply_discount" value="1"
                                                   id="apply_discount"
                                                   @if ($product->apply_discount) checked @endif
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
                                                            @if($product->discount_type === 'percentage') selected
                                                            @endif
                                                            value="percentage">{{ __('lang.percentage') }}</option>
                                                        <option
                                                            @if($product->discount_type === 'value') selected
                                                            @endif
                                                            value="value">{{ __('lang.value') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">{{ __('lang.discount_value') }}</label>
                                                    <input type="text" name="discount_value" id="discount_value"
                                                           value="{{ $product->discount_value }}"
                                                           class="form-control" data-parsle-type="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.short_desc') }}</label>
                                    <textarea class="form-control" rows="2" name="short_description"
                                              required>{{ $product->short_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.long_desc') }}</label>
                                    <textarea class="form-control" rows="2" name="long_description"
                                              required>{{ $product->long_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.allergy_info') }}</label>
                                    <textarea class="form-control" rows="2"
                                              name="allergy_info">{{ $product->allergy_info }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.storage_info') }}</label>
                                    <textarea class="form-control" rows="2"
                                              name="storage_info">{{ $product->storage_info }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="formFileMultiple" class="form-label">{{ __('lang.images') }}</label>
                                    <input class="form-control" type="file" id="formFileMultiple" name="images[]"
                                           multiple @if(count($product->images) == 0) required @endif/>
                                </div>
                            </div>
                            <div class="col-12">
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
