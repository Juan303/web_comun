@if(session('mensaje'))
    <div class="container">
        <div class="alert alert-{{ session('mensaje')['type'] }} alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('mensaje')['text'] }}
        </div>
    </div>
@endif
