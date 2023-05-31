<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid mx-lg-5 ">
    <a class="navbar-brand">Navbar</a>
    <ul class="d-flex gap-5 my-auto">
        <li><a href="{{ route('source') }}">Order Source</a></li>
        <li><a href="{{ route('list') }}">Order List</a></li>
        <li><a href="{{ route('week') }}">Weekly Report</a></li>
        <li><a href="{{ route('month') }}">Monthly Report</a></li>
    </ul>
    {{-- <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form> --}}
  </div>
</nav>
