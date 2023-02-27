@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.categories') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.category')]) }}</a>
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
                                <th></th>
                                <th>{{ __('lang.title') }}</th>
                                <th>{{ __('lang.parent_category') }}</th>
                                <th>{{ __('lang.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('/' . $category->image) }}" width="40" alt="cte">
                                    </td>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ $category->parent_category ? $category->parent_category->category : null }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="text-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($category->sub_categories()->count() === 0)
                                            <a href="{{ route('categories.delete', ['id' => $category->id]) }}" class="text-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        @endif
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

@endsection
@push('scripts')
    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });
    </script>
@endpush
