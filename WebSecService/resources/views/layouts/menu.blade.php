<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/even">Even Numbers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/prime">Prime Numbers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/multable">Multiplication Table</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/minitest">Minitest</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/Transcript">Transcript</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/calculator">Calculator</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/calculatorGPA">GPA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/users">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/grades">Grades</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link" href="{{ route('exercises3.Users.profile', ['user' => auth()->id()]) }}">{{ auth()->user()->name }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Register</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
