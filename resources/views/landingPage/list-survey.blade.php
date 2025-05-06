<!-- Main Content -->
<div class="container my-5">
    <h1 class="h3 mb-5 " style="font-weight: 900;">
        Kuesioner Tracer Study Politeknik Negeri Malang.
    </h1>

    <div class="survey-cards-vertical ">
        @if($data)
            @foreach($data as $item)
                <!-- Kuesioner Lulusan 1 -->
                <div class="card mb-4">
                    <div class="card-body py-4 px-4">
                        <h2 class="card-title h5 fw-bold mb-1">{{  $item->title ?? '' }}</h2>
                        <div class="text-muted small mb-3">
                            <span>{{ $item->period_year ?? '' }}</span>
                            <span> / </span>
                            <span>{{ $item->type == 'alumni' ? 'Kuesioner Alumni' : 'Kuisioner Pengguna Alumni' }}</span>
                        </div>
                        <p class="card-text mb-3">
                            {{ $item->description ?? '' }}
                        </p>
                        <a href="#" class="btn btn-primary px-4">Isi Kuesioner</a>
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
