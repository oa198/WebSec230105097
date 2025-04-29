<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <!-- Apps Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Apps
          </a>
          <ul class="dropdown-menu" aria-labelledby="appsDropdown">
            <li><a class="dropdown-item" href="/even">Even Numbers</a></li>
            <li><a class="dropdown-item" href="/prime">Prime Numbers</a></li>
            <li><a class="dropdown-item" href="/multable">Multiplication Table</a></li>
            <li><a class="dropdown-item" href="/minitest">Minitest</a></li>
            <li><a class="dropdown-item" href="/Transcript">Transcript</a></li>
            <li><a class="dropdown-item" href="/products">Products</a></li>
            <li><a class="dropdown-item" href="/calculator">Calculator</a></li>
            <li><a class="dropdown-item" href="/calculatorGPA">GPA</a></li>
            <li><a class="dropdown-item" href="/users">Users</a></li>
            <li><a class="dropdown-item" href="/grades">Grades</a></li>
          </ul>
        </li>
      </ul>

      <!-- Authentication -->
      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="{{ route('exercises3.Users.profile', ['user' => auth()->id()]) }}">
                Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
            </li>
          </ul>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
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
