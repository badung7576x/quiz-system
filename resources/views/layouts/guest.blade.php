<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>@yield('title')</title>

  <meta name="description" content="{{ config('setting.app_name') }}">
  <meta name="author" content="badung7576x">
  <meta name="robots" content="noindex, nofollow">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/quiz_256.png') }}">
  <link rel="icon" sizes="128x128" type="image/png" href="{{ asset('media/favicons/quiz_128.png') }}">
  <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('media/favicons/quiz_128.png') }}">

  <!-- Fonts and Styles -->
  @yield('css_before')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ mix('/css/oneui.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
  @yield('css_after')

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
  <div id="page-container">
    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
    </main>
    <!-- END Main Container -->
  </div>
  <!-- END Page Container -->
  <script src="{{ mix('js/oneui.app.js') }}"></script>
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script>
    let toast = Swal.mixin({
      buttonsStyling: false,
      target: '#page-container',
      customClass: {
        confirmButton: 'btn btn-success m-1',
        cancelButton: 'btn btn-danger m-1',
        input: 'form-control'
      }
    });
    @if (session()->has('message'))
      let type = "{{ session()->get('type') }}";
      let message = "{{ session()->get('message') }}";
      showNotify(type, message);
    @endif

    function showNotify(type, message) {
      toast.fire('Thông Báo', message, type);
    }
  </script>
  @yield('js_after')
</body>

</html>
