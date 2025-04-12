@extends('layouts.app')

@section('content')
@include('layouts.alerts')
<br>
<!-- =========================== start upload part ========================================== -->
<div class="form_shadow">
    <center><h4>Active Subjects</h4><br></center>

    <div class="container px-4">
        <div class="row md-3">
        @foreach($active_subjects as $subject)
            <div class="col">
                <div class="p-3 border bg-light">{{$subject->name}}</div>
            </div>
        @endforeach
        </div>
    </div>
</div>
<!-- =========================== end upload part ========================================== -->
@endsection