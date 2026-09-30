@php($messages = session())

@if ($messages->has('status'))
    <div class="alert alert-success d-flex align-items-center gap-2 fs-3" role="alert">
        <i class="ti ti-circle-check"></i>
        <span>{{ $messages->get('status') }}</span>
    </div>
@endif

@if ($messages->has('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 fs-3" role="alert">
        <i class="ti ti-alert-circle"></i>
        <span>{{ $messages->get('error') }}</span>
    </div>
@endif
