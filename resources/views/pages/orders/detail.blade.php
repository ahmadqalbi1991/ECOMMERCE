@extends('app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.order_detail') }} <a href="{{ route('orders.pdf', ['id' => $order->id]) }}" class="btn btn-primary float-right"><i class="bi bi-file-pdf"></i> Invoice</a></h5>
                </div>
                <div class="col-12">
                    <p>{{ $order->order_status }}</p>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.order_by') }}:</strong>
                        </div>
                        <div class="col-8">
                            <p>{{ $order->user->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.address') }}:</strong>
                        </div>
                        <div class="col-8">
                            @php
                                $address_object = json_decode($order->shipping_details);
                            @endphp
                            <p>{{ $address_object->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.receiver_name') }}:</strong>
                        </div>
                        <div class="col-8">
                            @php
                                $address_object = json_decode($order->shipping_details);
                            @endphp
                            <p>{{ $address_object->receiver_name ? $address_object->receiver_name : $order->user->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.contact_number') }}:</strong>
                        </div>
                        <div class="col-8">
                            @php
                                $address_object = json_decode($order->shipping_details);
                            @endphp
                            <p>{{ $address_object->contact_number ? $address_object->contact_number : '+' . $order->user->profile->contact_number }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>{{ __('lang.items') }} (<span>{{ $order->items->count() }}</span>)</h5>
            <div class="table-responsive">
                <table class="table table-stripped" id="table1">
                    <thead>
                    <tr>
                        <td></td>
                        <td>{{ __('lang.title') }}</td>
                        <td>{{ __('lang.qty') }}</td>
                        <td>{{ __('lang.subtotal') }}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $key => $item)
                        <tr>
                            <td>
                                <img src="{{ asset('/' . $item->product->default_image) }}" alt="product_img"
                                     width="100">
                            </td>
                            <td>{{ $item->product->product_title }}</td>
                            <td>{{ $item->qty }}</td>
                            <td><strong>RS. </strong>{{ $item->product->price * $item->qty }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.discount') }}</h5>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.promo_code_discount') }}:</strong>
                        </div>
                        <div class="col-8">
                            <p><strong>RS. </strong>{{ $order->promo_code_discount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>{{ __('lang.billu_bhai_discounts') }}:</strong>
                        </div>
                        <div class="col-8">
                            <p><strong>RS. </strong>{{ $order->points_discount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.order_total') }}</h5>
                </div>
                <div class="col-sm-6 col-md-6"></div>
                <div class="col-sm-6 col-md-6">
                    <h5>{{ __('lang.subtotal') }} <span class="float-right"><strong>RS. </strong>{{ number_format($order->sub_total, 2) }}</span></h5>
                    <h5>{{ __('lang.tax') }} <span class="float-right"><strong>RS. </strong>{{ number_format($order->tax, 2) }}</span></h5>
                    <h5>{{ __('lang.billu_bhai_discounts') }} <span class="float-right"><strong>RS. </strong>{{ number_format($order->points_discount, 2) }}</span></h5>
                    <h5>{{ __('lang.promo_code_discount') }} <span class="float-right"><strong>RS. </strong>{{ number_format($order->promo_code_discount, 2) }}</span></h5>
                    <hr>
                    <h5>{{ __('lang.total') }} <span class="float-right"><strong>RS. </strong>{{ number_format($order->sub_total + $order->tax - $order->points_discount -$order->promo_code_discount, 2) }}</span></h5>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush
