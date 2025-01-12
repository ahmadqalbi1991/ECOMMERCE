@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h5>{{ __('lang.units') }}</h5>
                </div>
                <div class="col-4 text-right">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-target="#addUnit" data-bs-toggle="modal"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.unit')]) }}</a>
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
                                <th>{{ __('lang.unit') }}</th>
                                <th>{{ __('lang.prefix') }}</th>
                                <th>{{ __('lang.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($units as $key => $unit)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $unit->unit }}</td>
                                    <td>{{ $unit->prefix }}</td>
                                    <td>
                                        <a href="{{ route('units.delete', ['id' => $unit->id]) }}" class="text-danger">
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
    <div class="modal" tabindex="-1" role="dialog" id="addUnit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('lang.add_option', ['field' => __('lang.unit')]) }}</h5>
                </div>
                <form action="{{ route('units.store') }}" method="post" data-parsley-validate>
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.unit') }}</label>
                                    <input type="text" name="unit" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.prefix') }}</label>
                                    <input type="text" name="prefix" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> {{ __('lang.add_option', ['field' => __('lang.unit')]) }}</button>
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
        let dataTable = new simpleDatatables.DataTable(table1, {
            "ordering": false
        });
    </script>
@endpush

