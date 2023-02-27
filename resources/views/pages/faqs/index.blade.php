@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.faqs') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('faqs.create') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.faqs')]) }}</a>
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
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($faqs as $key => $faq)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $faq->question }}</td>
                            <td>
                                <a href="{{ route('faqs.edit', ['id' => $faq->id]) }}"><span class="bi bi-pencil"></span></a>
                                <a href="{{ route('faqs.delete', ['id' => $faq->id]) }}" class="text-danger"><span class="bi bi-trash"></span></a>
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
