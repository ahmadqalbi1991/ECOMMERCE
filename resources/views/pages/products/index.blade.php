@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.products') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('products.add') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.product')]) }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{--            <div class="row">--}}
            {{--                <div class="col-12">--}}
            <div class="table-responsive">
                <table class="table table-stripped" id="table1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.category') }}</th>
                        <th>{{ __('lang.sku') }}</th>
                        <th>{{ __('lang.price') }}</th>
                        <th>{{ __('lang.qty') }}</th>
                        <th>{{ __('lang.unit') }}</th>
                        <th>{{ __('lang.discount') }}</th>
                        <th>{{ __('lang.discounted_price') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        @if(!empty($product->slug))
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset('/' . $product->default_image) }}" alt="product_img"
                                         width="100">
                                </td>
                                <td>{{ $product->product_title }}</td>
                                <td>{{ $product->category ? $product->category->category : 'Others'}}</td>
                                <td>{{ $product->sku_code }}</td>
                                <td>RS. {{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->unit ? $product->unit_value . $product->unit->prefix : 'Others'}}</td>
                                <td>{{ $product->apply_discount ? ($product->discount_type === 'value' ? 'RS.' . $product->discount_value : $product->discount_value . '%') : '--' }}</td>
                                <td>
                                    @if($product->apply_discount)
                                        @if($product->discount_type === 'value')
                                            RS. {{ $product->price - $product->discount_value }}
                                        @else
                                            @php
                                                $discount = ($product->price * $product->discount_value) / 100
                                            @endphp
                                            RS. {{ $product->price - $discount }}
                                        @endif
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', ['slug' => $product->slug]) }}"
                                       class="text-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a data-url="{{ route('products.delete', ['slug' => $product->slug]) }}"
                                       class="text-danger delete-item" href="javascript:void(0);">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
