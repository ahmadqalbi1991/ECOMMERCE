@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.suppliers') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-target="#addSupplier" data-bs-toggle="modal"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.supplier')]) }}</a>
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
                        <th>{{ __('lang.supplier') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($suppliers as $key => $supplier)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>
                                <a href="{{ route('suppliers.edit', ['id' => $supplier->id]) }}" class="text-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a data-url="{{ route('suppliers.delete', ['id' => $supplier->id]) }}" class="text-danger delete-item" href="javascript:void(0);">
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
    <div class="modal" tabindex="-1" role="dialog" id="addSupplier">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.add_option', ['field' => __('lang.supplier')]) }}</h5>
                </div>
                <form action="{{ route('suppliers.save') }}" method="post" data-parsley-validate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.name') }}</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('lang.add_option', ['field' => __('lang.supplier')]) }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                    </div>
                </form>
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
