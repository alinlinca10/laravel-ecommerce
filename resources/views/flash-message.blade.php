@if (session()->has('success'))
    <div class="alert alert-warning alert-dismissible fade show po" role="alert">
        <strong><i class="bi bi-check-lg"></i></strong> {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif