@extends('app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-stripped" id="table1">
                    <thead>
                    <tr>
                        <th>{{ __('lang.order_no') }}</th>
                        <th>{{ __('lang.customer') }}</th>
                        <th>{{ __('lang.items') }}</th>
                        <th>{{ __('lang.total') }}</th>
                        <th>{{ __('lang.order_date') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>INV_{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td><strong>RS.</strong> {{ number_format($order->sub_total + $order->tax, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                            <td>
                                <div class="flex">
                                    <form action="{{ route('orders.change-status') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->id }}">
                                        <div class="d-flex">
                                            <select name="order_status" id="status_{{ $key }}" class="form-control"
                                                    @if(in_array($order->order_status, ['confirmed', 'cancelled'])) disabled @endif>
                                                <option value="pending"
                                                        @if($order->order_status === 'pending') selected @endif>Pending
                                                </option>
                                                <option value="cancelled"
                                                        @if($order->order_status === 'cancelled') selected @endif>
                                                    Cancelled
                                                </option>
                                                <option value="confirmed"
                                                        @if($order->order_status === 'confirmed') selected @endif>
                                                    Confirmed
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-success"><span
                                                    class="bi bi-save"></span> Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('orders.detail', ['id' => 'INV_' . $order->id]) }}"
                                   class="text-primary"><strong><i class="bi bi-eye-fill"></i></strong></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
