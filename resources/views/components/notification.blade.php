<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        @if($type == 'success')
            <i data-feather="check-circle" class="me-2"></i>
        @elseif($type == 'danger')
            <i data-feather="alert-circle" class="me-2"></i>
        @elseif($type == 'warning')
            <i data-feather="alert-triangle" class="me-2"></i>
        @elseif($type == 'info')
            <i data-feather="info" class="me-2"></i>
        @endif
        <div>
            {{ $message }}
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
