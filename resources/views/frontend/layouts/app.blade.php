{{-- <!DOCTYPE html>
<html lang="en" class="scrol-pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ isset($exceptionMeta) ? $exceptionMeta->description : meta(Route::current()->uri(), 'description') }}">
    <meta name="keywords" content="{{ isset($exceptionMeta) ? $exceptionMeta->keywords : meta(Route::current()->uri(), 'keywords') }}">
    <title>{{ isset($exceptionMeta) ? $exceptionMeta->title : meta(Route::current()->uri(), 'title') }}{{ isset($additionalTitle) ? ' | '.$additionalTitle : '' }}</title>
    @include('frontend.layouts.common.style')

    <script type="text/javascript">
        var SITE_URL = "{{ url('/') }}";
    </script>

</head>
<body>
	
     <!-- Start scroll-top button -->
    <div id="scroll-top-area">
        <a href="{{url()->current()}}#top-header"><i class="fas fa-arrow-up"></i></a>
    </div>
    <!-- End scroll-top button -->
    
    <!-- Start Header -->
    @include('frontend.layouts.common.header')
    <!-- End Header -->

    @yield('content')

    <!-- Start Footer-->
    @include('frontend.layouts.common.footer_menu')
    <!-- End Footer -->

    @include('frontend.layouts.common.script')

    @yield('js')
</body>
</html> --}}


<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ ucfirst(settings('name')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paylio - Money Transfer and Online Payments HTML Template</title>

    <link rel="shortcut icon" href="{{ faviconPath() }}" type="image/x-icon">

    @include('frontend.layouts.common.style')

</head>

<body>

    <!-- start LTR to RTL -->
    <div class="position-fixed d-flex flex-column text-center" id="draggableDiv">
        <button id="btn-ltr" class="rounded-2 py-2 px-3">LTR</button>
        <span class="draggable py-2"><i class="fas fa-arrows-alt xxlr m-0"></i></span>
        <button id="btn-rtl" class="rounded-2 py-2 px-3">RTL</button>
    </div>
    <!-- end LTR to RTL -->

    <!-- start preloader -->
    <div class="preloader" id="preloader"></div>
    <!-- end preloader -->

    <!-- Scroll To Top Start-->
    <a href="javascript:void(0)" class="scrollToTop"><i class="fas fa-angle-double-up"></i></a>
    <!-- Scroll To Top End -->

    <!-- header-section start -->
    @include('frontend.layouts.common.header')
    <!-- header-section end -->

    @yield('content')

    <!-- Footer Area Start -->
    @include('frontend.layouts.common.footer')
    <!-- Footer Area End -->

    @include('frontend.layouts.common.script')

</body>

</html>