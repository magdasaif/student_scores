@extends('layouts.app')

@section('content')
    @include('layouts.alerts')
    <br>
    <!-- =========================== start upload part ========================================== -->
    <div class="form_shadow">
        <center><h6 class="mb-1 font-medium" style="color:red;">If you need template for csv file , download it from Template tab</h6><br></center>

        <h4 class="mb-1 font-medium">Let's get started</h4>
        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">upload students scores for reformating</p>
        <form  action="{{route('scores.process')}}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('POST')
            <div class="mb-3">
                <input class="form-control form-control-sm" id="file" name="file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
            </div>
            <center>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">process scores</button>
                </div>
            </center>
        </form>
    </div>
    <!-- =========================== end upload part ========================================== -->
@endsection