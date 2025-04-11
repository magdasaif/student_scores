@extends('layouts.app')

@section('content')
  @include('layouts.alerts')
  <br>
    <!-- ============================= style section ============================================ -->
    @section('style')
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">        
      
      <!-- Styles / Scripts -->
      @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
          @vite(['resources/css/app.css', 'resources/js/app.js'])
      @else
          @include('layouts.styles')
      @endif
    @endsection
    <!-- =========================== start upload part ========================================== -->
    <div class="form_shadow">
        <h1 class="mb-1 font-medium">Let's get started</h1>
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">upload students scores for filteration</p>
        <form  action="{{route('scores.process')}}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('POST')
            <div class="mb-3">
                <input class="form-control form-control-sm" id="file" name="file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">process scores</button>
            </div>
        </form>
    </div>
    <!-- =========================== end upload part ========================================== -->
@endsection