<div class="panel-auth h-100 p-4 d-flex flex-column justify-content-center text-center"
     @if($fotoPublik('login'))
       style="background-image: linear-gradient(rgba(30,90,56,.82), rgba(30,90,56,.82)), url({{ $fotoPublik('login') }}); background-size: cover; background-position: center;"
     @endif>

  @if($fotoPublik('logo'))
    <img src="{{ $fotoPublik('logo') }}" alt="Logo Pandawa Farm" height="64"
         class="mx-auto mb-3 bg-white rounded-circle p-1">
  @else
    <span class="logo-placeholder mx-auto mb-3" style="width:64px;height:64px;font-size:1.2rem;">PF</span>
  @endif

  <h3 class="mb-2">{{ $judul }}</h3>
  <p class="mb-0">{{ $teks }}</p>
</div>
