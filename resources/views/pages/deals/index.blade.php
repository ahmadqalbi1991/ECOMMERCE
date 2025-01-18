@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.deals') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('deals.create') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.deal')]) }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-stripped" id="table1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('lang.title') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($deals as $key => $deal)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $deal->title }}</td>
                            <td>
                                @if($deal->is_active)
                                    <a href="{{ route('deals.change-status', ['id' => $deal->id, 'status' => 0]) }}" class="btn btn-success btn-sm">{{ __('lang.is_active') }}</a>
                                @else
                                    <a href="{{ route('deals.change-status', ['id' => $deal->id, 'status' => 1]) }}" class="btn btn-danger btn-sm">{{ __('lang.disable') }}</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('deals.edit', ['id' => $deal->id]) }}"><span
                                        class="bi bi-pencil"></span></a>
                                <a data-url="{{ route('deals.delete', ['id' => $deal->id]) }}" class="text-danger delete-item" href="javascript:void(0);"><span
                                        class="bi bi-trash"></span></a>
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
