<!-- resources/views/subjects/create.blade.php -->
@extends('layouts.app')

@section('content')

<!-- =========================== start upload part ========================================== -->
<div class="form_shadow">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- <div class="card"> -->
                    <div class="card-header">Create Subject</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('subjects.store') }}">
                            @csrf
    
                            <div class="mb-3">
                                <label for="name" class="form-label">Subject Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <h5>Initial Scores</h5>
                                <div id="scores-container">
                                    <!-- Score fields will be added here dynamically -->
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-score">Add Score</button>
                            </div>
    
                            <div class="mb-3">
                                <center><button type="submit" class="btn btn-primary">Create Subject</button></center>
                                {{-- <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a> --}}
                            </div>
                        </form>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

    @section('scripts')
        <script>
            //==================================================================================
            $(document).ready(function() {
                let scoreCount = 0;
                //==================================================================================
                $('#add-score').click(function() {
                    var scoreRow = `<div class="row mb-2 score-row">
                        <div class="col-5">
                            <input type="text"  class="form-control" name="scores[]" placeholder="Score" required>
                        </div>
                        <div class="col-5">
                            <input type="number" class="form-control" name="sort[]" placeholder="Sort Order" value="0" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger remove-score">Remove</button>
                        </div>
                    </div>`;
                    $('#scores-container').append(scoreRow);
                    scoreCount++;
                });
               //==================================================================================
                $(document).on('click', '.remove-score', function() {
                    $(this).closest('.score-row').remove();
                });
            //==================================================================================
            });
            //==================================================================================
        </script>
    @endsection
@endsection