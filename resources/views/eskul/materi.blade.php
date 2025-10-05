<link rel="icon" href="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" type="image/png"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Materi</title>

<div class="container my-5">

    @foreach ($data as $dt)
        <!-- Tombol kembali -->
        <div class="mb-4">
            <a href="{{ route('lihateskul', ['cabang' => $dt->cabang_eskul]) }}" class="btn btn-primary">
                ← Kembali ke Eskul {{ $dt->cabang_eskul }}
            </a>
        </div>

        <!-- Artikel -->
        <article class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="card-title mb-3">{{ $dt->title }}</h1>
                <div class="text-muted mb-3">
                    <small>
                        📌 Cabang: {{ $dt->cabang_eskul }} &nbsp; | &nbsp;  
                        ✍️ Oleh: {{ $dt->upload_by }} &nbsp; | &nbsp;  
                        🕒 {{ $dt->created_at->format('d M Y, H:i') }}
                    </small>
                </div>

                <hr>

                <div class="card-text fs-5" style="line-height: 1.8;">
                    {!! nl2br(e($dt->deskripsi)) !!}
                </div>
            </div>
        </article>
    @endforeach

</div>
