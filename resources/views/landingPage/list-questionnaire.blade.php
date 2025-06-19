<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;" >
        Kuesioner Tracer Study Politeknik Negeri Malang.
        <button style="float: right" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#infoModal" onclick="onWalkthrough()">?</button>
    </h1>

    <div class="survey-cards-vertical ">
        @if ($data)
            @php
                $alumniFirst = false;
                $superiorFirst = false;
            @endphp

            @foreach ($data as $item)
                @php
                    $dataIntroAttribute = '';

                    if ($item->type == 'alumni' && !$alumniFirst) {
                        $dataIntroAttribute = "data-intro='Jika kamu adalah alumni, silahkan pilih tipe kuesioner lulusan seperti ini'";
                        $alumniFirst = true;
                    } elseif ($item->type == 'superior' && !$superiorFirst) {
                        $dataIntroAttribute =
                            "data-intro='Jika kamu adalah pengguna lulusan, silahkan pilih tipe kuesioner pengguna lulusan seperti ini'";
                        $superiorFirst = true;
                    }
                @endphp

                <div class="card mb-4 card-hover" {!! $dataIntroAttribute !!}>
                    <div class="card-body py-4 px-4">
                        <h2 class="card-title h5 fw-bold mb-1">{{ $item->title ?? '' }}</h2>
                        <div class="text-muted small mb-3">
                            {{-- <span>{{ $item->period_year ?? '' }}</span> --}}
                            {{-- <span> / </span> --}}
                            <span>{{ $item->type == 'alumni' ? 'Kuesioner Lulusan' : 'Kuisioner Pengguna Lulusan' }}</span>
                        </div>
                        <p class="card-text mb-3">
                            {{ $item->description ?? '' }}
                        </p>
                        <a href="{{ route('questionnaire.show', $item->id) }}" class="btn btn-primary px-4">Isi
                            Kuesioner</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card mb-4">
                <div class="card-body py-4 px-4">
                    <h2 class="card-title h5 fw-bold mb-1">Tidak ada kuesioner</h2>
                </div>
            </div>
        @endif

    </div>
</div>
<div style="height: 200px"></div>
<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<script>
    onWalkthrough = () => {
        introJs().start();
    }
</script>
