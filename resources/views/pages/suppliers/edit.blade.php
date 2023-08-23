    @extends('app')
    @section('content')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h5>{{ __('lang.edit_option', ['field' => __('lang.supplier')]) }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('suppliers.update', ['id' => $supplier->id]) }}" method="post" data-parsley-validate>
                    <div class="row">
                        <div class="col-12">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">{{ __('lang.name') }}</label>
                                        <input type="text" value="{{ $supplier->name }}" name="name" class="form-control"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary"><i
                                    class="bi bi-save"></i> {{ __('lang.save', ['field' => __('lang.supplier')]) }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
