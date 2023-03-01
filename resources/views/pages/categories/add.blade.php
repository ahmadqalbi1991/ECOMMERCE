@extends('app')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <h5>{{ __('lang.add_option', ['field' => __('lang.category')]) }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('categories.store') }}" method="post" data-parsley-validate
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($category->id) ? $category->id : null }}">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.title') }}</label>
                                    <input type="text" name="category" id="title" class="form-control" required
                                           value="{{ isset($category->category) ? $category->category : null }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.level') }}</label>
                                    <select name="level" id="level" class="form-control">
                                        @for($i = 1; $i <= 3; $i++)
                                            <option @if (isset($category->level) && $category->level === $i) selected
                                                    @endif value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.parent_category') }}</label>
                                    <select name="parent_id" id="parent_id" class="form-control" disabled>
                                        <option value="">{{ __('lang.select_option') }}</option>
                                        @foreach($categories as $category_obj)
                                            <option
                                                @if (isset($category->parent_id) && $category->parent_id === $category_obj->id) selected
                                                @endif value="{{ $category_obj->id }}">{{ $category_obj->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-goup">
                                    <label for=""></label>
                                    <div class="form-check">
                                        <div class="checkbox">
                                            <input type="checkbox" name="is_nav" value="1"
                                                   id="checkbox1"
                                                   @if (isset($category->is_nav) && $category->is_nav) checked
                                                   @endif class="form-check-input">
                                            <label
                                                for="checkbox1">{{ __('lang.is_nav') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">{{ __('lang.image') }}</label>
                                    <input type="file" name="image" class="dropify"
                                           @if(isset($category->image) && $category->image)  data-default-file="{{ asset('/' . $category->image) }}"
                                           @else required @endif>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success"><i
                                        class="bi bi-save"></i> {{ __('lang.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $("#level").on("change", function () {
                if ($(this).val() !== 1) {
                    $.ajax({
                        url: '{{ route("categories.get-parent-category") }}',
                        data: {level: $(this).val()},
                        type: 'POST',
                        headers: {
                            "X-CSRF-Token": "{{ csrf_token() }}"
                        },
                        success: (response) => {
                            let parent_id = $("#parent_id");
                            parent_id.removeAttr("disabled").html(response);
                        }
                    })
                }
            })
        </script>
    @endpush

@endsection
