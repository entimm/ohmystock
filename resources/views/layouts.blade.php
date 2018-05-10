<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OH MY STOCK</title>
    <link href="css/app.css" rel="stylesheet">
    @stack('csses')
    <style>
        .box {
            padding: 5px;
            margin: 5px 0px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
        }
    </style>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">OH MY STOCK</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/monitor">monitor</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/list">list</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/daily_list">daily</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/add">add</a>
            </li>
          </ul>
          @yield('right_nav')
        </div>
      </nav>
    </header>
    <main role="main" id="app">
      @yield('content')
    </main>
    <script src="js/app.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>
