@extends('app')
@section('content')
    @if($is_active)
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h5>{{ __('lang.promo_codes') }}</h5>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('promo-codes.create')  }}" class="btn btn-primary btn-sm"><i
                                class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.promo_code')]) }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-stripped" id="table1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('lang.title') }}</th>
                                    <th>{{ __('lang.promo_code') }}</th>
                                    <th>{{ __('lang.validity_date') }}</th>
                                    <th>{{ __('lang.status') }}</th>
                                    <th>{{ __('lang.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promo_codes as $key => $code)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $code->title }}</td>
                                        <td>{{ $code->code }}</td>
                                        <td>{{ \Carbon\Carbon::parse($code->validity_from)->format('d M, Y') }}
                                            - {{ \Carbon\Carbon::parse($code->validity_to)->format('d M, Y') }}</td>
                                        <td>
                                            @if($code->is_active)
                                                <p class="text-success">{{ __('lang.is_active') }}</p>
                                            @else
                                                <p class="text-danger">{{ __('lang.disable') }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('promo-codes.edit', ['id' => $code->id]) }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('promo-codes.delete', ['id' => $code->id]) }}"
                                               class="text-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <h6>{{ __('lang.disable_notice', ['field' => __('lang.promo_codes')]) }}</h6>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });
    </script>
@endpush
