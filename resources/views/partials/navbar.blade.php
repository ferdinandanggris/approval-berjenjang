<nav class="fixed-top navbar navbar-expand-lg navbar-light navbar-bg">
  <div class="container">
      <a class="navbar-brand text-white" href="/"><b>Sistem Informasi Manajemen</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mx-2">
                <a class="text-white nav-link {{Request::is('/')? 'active' : ''}}" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item mx-2">
                <a class="text-white nav-link {{Request::is('leave_application*')? 'active' : ''}}" href="/leave_application">Leave Application</a>
            </li>
            <li class="nav-item mx-2">
                <a class="text-white nav-link {{Request::is('travel_authorization*')? 'active' : ''}}" href="/travel_authorization">Travel Authorization</a>
            </li>
            <li class="nav-item mx-2">
                <a class="text-white nav-link {{Request::is('user*')? 'active' : ''}}" href="/user">User</a>
            </li>
            <li class="nav-item mx-2 mt-auto text-white nav-link">
                | <span>Hello, {{auth()->user()->name ?? ''}}</span>
            </li>
            @auth
            <li class="nav-item mx-2 mt-auto mb-1">
              <form action="/logout" method="post">
                @csrf
                  <button type="submit" class="dropdown-item bg-danger text-white btn btn-danger">Logout</button>
              </form>
            </li>
            @endauth

        </ul>
    </div>
  </div>
</nav>
