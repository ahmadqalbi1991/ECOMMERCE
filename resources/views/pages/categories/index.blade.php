@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm"><i
                            class="bi bi-plus"></i> {{ __('lang.add_option', ['field' => __('lang.category')]) }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-1">
                            <h5>#</h5>
                        </div>
                        <div class="col-6">
                            <h5>{{ __('lang.title') }}</h5>
                        </div>
                        <div class="col-2 text-right">
                            <h5>{{ __('lang.actions') }}</h5>
                        </div>
                        <div class="col-3"></div>
                    </div>
                    <div class="row">
                        <div class="accordion" id="accordionExample_0">
                            @foreach($categories as $key => $category)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="category_{{ $key }}">
                                        <div class="row w-100 align-items-center px-2">
                                            <div class="col-1">
                                                <h6>
                                                    {{ $key + 1 }}
                                                </h6>
                                            </div>
                                            <div class="col-6">
                                                <h6>
                                                    {{ $category->category }}
                                                </h6>
                                            </div>
                                            <div class="col-2 text-right">
                                                <h6>
                                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}">
                                                        <i class="bi bi-pen"></i>
                                                    </a>
                                                    <a class="text-danger delete-item" href="javascript:void(0);"
                                                       data-url="{{ route('categories.delete', ['id' => $category->id]) }}">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="col-3">
                                                @if($category->sub_categories()->count())
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_{{ $key }}" aria-expanded="false"
                                                            aria-controls="collapseOne">
                                                        {{ __('lang.sub_categories') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="collapse_{{ $key }}" class="accordion-collapse collapse"
                                         aria-labelledby="category_{{ $key }}" data-bs-parent="#accordionExample_0">
                                        <div class="accordion-body">
                                            <div class="accordion" id="accordionExample_sub_{{ $key }}">
                                                @foreach($category->sub_categories as $key1 => $category)
                                                    <div class="accordion-item border-0">
                                                        <h2 class="accordion-header" id="subcategory_{{ $key1 }}">
                                                            <div class="row w-100 align-items-center">
                                                                <div class="col-1">
                                                                    <h6>
                                                                        {{ $key + 1 }}.{{ $key1 + 1 }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-6">
                                                                    <h6>
                                                                        {{ $category->category }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-2 text-right">
                                                                    <h6>
                                                                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}">
                                                                            <i class="bi bi-pen"></i>
                                                                        </a>
                                                                        <a class="text-danger delete-item"
                                                                           href="javascript:void(0);"
                                                                           data-url="{{ route('categories.delete', ['id' => $category->id]) }}">
                                                                            <i class="bi bi-trash"></i>
                                                                        </a>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-3">
                                                                    @if($category->sub_categories()->count())
                                                                        <button class="accordion-button collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#subcollapse_{{ $key1 }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseOne">
                                                                            {{ __('lang.sub_categories') }}
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </h2>
                                                        <div id="subcollapse_{{ $key1 }}"
                                                             class="accordion-collapse collapse"
                                                             aria-labelledby="category_{{ $key1 }}"
                                                             data-bs-parent="#accordionExample_sub_{{ $key }}">
                                                            <div class="accordion-body">
                                                                @foreach($category->sub_categories as $key2 => $category)
                                                                    <div class="accordion-item border-0">
                                                                        <h2 class="accordion-header"
                                                                            id="multi_subcategory_{{ $key2 }}">
                                                                            <div
                                                                                class="row w-100 align-items-center">
                                                                                <div class="col-1">
                                                                                    <h6>
                                                                                        {{ $key + 1 }}.{{ $key1 + 1 }}
                                                                                        .{{ $key2 + 1 }}
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <h6>
                                                                                        {{ $category->category }}
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="col-2 text-right">
                                                                                    <h6>
                                                                                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}">
                                                                                            <i class="bi bi-pen"></i>
                                                                                        </a>
                                                                                        <a class="text-danger delete-item"
                                                                                           href="javascript:void(0);"
                                                                                           data-url="{{ route('categories.delete', ['id' => $category->id]) }}">
                                                                                            <i class="bi bi-trash"></i>
                                                                                        </a>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </h2>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
