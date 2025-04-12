@extends('layouts.app')

@section('content')
    @include('layouts.alerts')
    <br>
    <!-- =========================== start upload part ========================================== -->
    <div class="form_shadow">
        <div class="form-group text-end mb-4">
            <center><h6 class="mb-1 font-medium">Download csv student score temlate</h6><br>
            <a class="btn btn-primary" href="{{ asset('csv_files/scores.csv') }}" download> Download Score Template </a></center>
        </div>
    </div>
    <!-- =========================== end upload part ========================================== -->
@endsection