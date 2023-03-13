@extends('app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-stripped" id="table1">
                    <thead>
                    <tr>
                        <th>{{ __('lang.customer') }}</th>
                        <th>{{ __('lang.review') }}</th>
                        <th>{{ __('lang.rating') }}</th>
                        <th>{{ __('lang.date') }}</th>
                        <th>{{ __('lang.status') }}</th>
                        <th>{{ __('lang.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->user->name }}</td>
                            <td>
                                {{ $feedback->review }}
                            </td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ ($i <= $feedback->rating) ? 'bi-star-fill text-warning' : 'bi-star' }}"></i>
                                @endfor
                            </td>
                            <td>{{ \Carbon\Carbon::parse($feedback->created_at)->format('d M, Y') }}</td>
                            <td>
                                @if($feedback->published)
                                    <span class="btn btn-sm btn-success">{{ __('lang.published') }}</span>
                                @else
                                    <span class="btn btn-sm btn-danger">{{ __('lang.unpublished') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0)" data-bs-target="#reviewModal_{{ $feedback->id }}" data-bs-toggle="modal" class="text-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!$feedback->published)
                                    <a href="{{ route('feedbacks.published', ['id' => $feedback->id, 'status' => 1]) }}" class="text-success">
                                        <i class="bi bi-check2-all"></i>
                                    </a>
                                @else
                                    <a href="{{ route('feedbacks.published', ['id' => $feedback->id, 'status' => 0]) }}" class="text-danger">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                                <a href="{{ route('feedbacks.delete', ['id' => $feedback->id]) }}" class="text-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            <div class="modal" tabindex="-1" role="dialog" id="reviewModal_{{ $feedback->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('lang.review') }}</h5>
                                        </div>
                                            <div class="modal-body">
                                                <p>{{ $feedback->review }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
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
