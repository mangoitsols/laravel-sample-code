<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="/img/fav.png">
    <title>Hodify | @yield('title') </title>

    {{-- Plugins styles --}}
    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    {{-- Inspinia theme and custom styles --}}
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    @section('head-scripts')
    @show

</head>
<body>

  <div id="app">

    <!-- Wrapper-->
      <div id="wrapper">

          <!-- Navigation -->
          @include('layouts.navigation')

          <!-- Page wraper -->
          <div id="page-wrapper" class="gray-bg">

              <!-- Page wrapper -->
              @include('layouts.topnavbar')

              <!-- Success message -->
              @if (session('success'))
                  <div class="alert alert-success alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      {{ session('success') }}
                  </div>
              @endif
              <!-- Error message -->
              @if (session('error'))
                  <div class="alert alert-danger alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      {{ session('error') }}
                  </div>
              @endif
              <!-- Warning message -->
              @if (session('warning'))
                  <div class="alert alert-warning alert-dismissable">
                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      {{ session('warning') }}
                  </div>
              @endif

              <!-- Main view  -->
              @yield('content')

              <!-- Footer -->
              @include('layouts.footer')

              <div class="sk-spinner sk-spinner-three-bounce page-load-spinner">
                <div class="sk-bounce1"></div>
                <div class="sk-bounce2"></div>
                <div class="sk-bounce3"></div>
              </div>

          </div>
          <!-- End page wrapper-->

          {{-- Danger modal --}}
          <danger-modal></danger-modal>

          {{-- Support ticket modal --}}
          <support-ticket :user-info="{{ Auth::user() }}"></support-ticket>

      </div>
      <!-- End wrapper-->

  </div>

{{-- Global JS --}}
<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>
{{-- Common scripts --}}
<script src="{!! asset('js/common.js') !!}" type="text/javascript"></script>

@section('scripts')
@show

</body>
</html>
