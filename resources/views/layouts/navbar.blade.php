<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <div class="container-fluid">

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{route('subjects.create')}}">Add Subject</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('scores.template')}}">Templates</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('scores.upload')}}">Csv Scores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>