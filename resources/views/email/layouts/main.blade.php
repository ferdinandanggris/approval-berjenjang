<!doctype html>
<html lang="en">

<style>
  .main{
    min-height: 10rem;
  }
</style>

<head>
    <!-- Required meta tags -->
    <title>{{ $title ?? 'Sistem Informasi Manajemen' }}</title>
</head>

<body>
  @include('email.partials.header')
    <div class="main mt-5 pt-3">
        <div class="container">
            @yield('container')
        </div>
    </div>
    @include('email.partials.footer')

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
</body>

</html>
