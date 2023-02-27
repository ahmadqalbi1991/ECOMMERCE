@extends('app')
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('faqs.save') }}" method="post" data-parsley-validate>
                @if(!empty($faq))
                    <input type="hidden" name="id" value="{{ $faq->id }}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.title') }}</label>
                            <input type="text" name="question" value="{{ !empty($faq) ? $faq->question : null }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{ __('lang.desc') }}</label>
                            <textarea name="answer" rows="5" class="form-control textarea" required>{{ !empty($faq) ? $faq->answer : null }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
