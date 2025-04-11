<!-- ======================================= sucess alert ======================================== -->
@if(session()->has('success'))
<center>
    <div class="alert alert-success" style="width: 100%;">
      {{session('success')}}
    </div>
</center>
@endif
<!-- ============================================================================================ -->

<!-- ======================================= errors alert ======================================== -->
@if(session()->has('errors') && is_array(session('errors')) && count($errors) > 0)
<center>
    <div class="alert alert-danger" style="width: 100%;">
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach      
            </ul>
        </div>
    </div>
</center>
@endif

<!-- ======================================= errors alert ======================================== -->
@if ($errors->any())
<center>
    <div class="a-t alert-danger" style="width: 100%;">
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach      
            </ul>
        </div>
    </div>
</center>
@endif
<!-- ============================================================================================ -->