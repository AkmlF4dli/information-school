<link rel="icon" href="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" type="image/png"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<title>Eskul {{ $cabang }}</title>
<div class="container mt-4">

    <!-- Tombol ke menu utama -->
    <div class="mb-3">
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
            ← Kembali ke Menu Utama
        </a>
    </div>

@php
$user = Auth::user();
$eskuls = [
    $user->cabang_eskul,
    $user->cabang_eskul2,
    $user->cabang_eskul3,
];
@endphp

@if(in_array($cabang, $eskuls))
    <center><h1>Eskul {{ $cabang }}</h1></center>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        @foreach ($events as $event)
           @if ($cabang == $event->cabang_eskul)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($event->deskripsi, 100) }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <div>Cabang: {{ $event->cabang_eskul }}</div>
                            <div>Upload by: {{ $event->upload_by }}</div>
                            <div>Upload at: {{ $event->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <!-- Tombol View More -->
                        <a href="{{ route('events.more', ['cabang_eskul' => $event->cabang_eskul, 'title' => $event->title]) }}" class="btn btn-sm btn-outline-primary">
                            View More
                        </a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@else
<form action="{{ route('eskul.daftar', $cabang) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">
        Daftar Eskul {{ $cabang }}
    </button>
</form>
@endif
