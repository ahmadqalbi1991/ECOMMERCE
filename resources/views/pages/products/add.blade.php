@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.add_option', ['field' => __('lang.product')]) }} wtf </h5>
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
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.title') }}</label>
                                    <input type="text" name="product_title" id="product_title" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.sku') }}</label>
                                    <input type="text" name="sku_code" id="sku_code" class="form-control"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.price') }}</label>
                                    <input type="text" name="price" id="price" class="form-control" required
                                           data-parsley-type="number">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.qty') }}</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required
                                           data-parsley-type="number">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
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
                            <div class="col-sm-12 col-md-6">
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
                            <div class="col-sm-12 col-md-6">
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
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit_value') }}</label>
                                    <input type="text" name="unit_value" id="unit_value" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('lang.product_type') }}</label><br><br>
                                    <input type="radio" class="btn-check" value="simple" name="product_type"
                                           id="success-outlined" autocomplete="off" required>
                                    <label class="btn btn-outline-primary"
                                           for="success-outlined">{{ __('lang.simple') }}</label>
                                    &nbsp;
                                    <input type="radio" class="btn-check" value="variant" name="product_type"
                                           id="success-outlined-1" autocomplete="off" required>
                                    <label class="btn btn-outline-primary"
                                           for="success-outlined-1">{{ __('lang.variant') }}</label>
                                </div>
                            </div>
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
                                            <input type="checkbox" name="apply_discount" value="1" id="checkbox1"
                                                   class="form-check-input">
                                            <label
                                                for="checkbox1">{{ __('lang.apply_discount') }}</label>
                                        </div>
                                        <div class="row d-none" id="discount-section">
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
                                                    <label for="">{{ __('label.discount_value') }}</label>
                                                    <input type="text" name="discount_value" id="discount_value"
                                                           class="form-control" data-parsle-type="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.attribute') }}</label>
                                            <select name="product[attributes][]" class="form-control">
                                                <option value="">{{ __('lang.select_option') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.option') }}</label>
                                            <select name="product[options][]" class="form-control">
                                                <option value="">{{ __('lang.select_option') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <div class="form-group">
                                            <label for="">{{ __('lang.price') }}</label>
                                            <input type="text" class="form-control" required data-parsley-type="number">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <a href="#" class="text-danger">
                                            &times;
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.short_desc') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="short_description"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.long_desc') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="long_description"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.allergy_info') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="allergy_info"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.storage_info') }}</label>
                                    <textarea class="form-control textarea" rows="10" name="storage_info"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.default_image') }}</label>
                                    <input type="file" name="default_image" id="default_image" class="dropify" required>
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
        })
    </script>
@endpush
