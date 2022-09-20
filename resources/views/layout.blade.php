
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('css')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</head>

<body>

<header>

    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="{{ route('product.list') }}" class="navbar-brand d-flex align-items-center">
                <strong>Online Shop</strong>
            </a>
            <ul class="list-unstyled">
                <li><a href="{{ route('product.list') }}" class="text-white">Shop Backend</a></li>
            </ul>
        </div>
    </div>
</header>

<main role="main">

    @yield('body')

</main>
<!-- Bootstrap core JavaScript
================================================== -->

<script src=" {{ asset('js/popper.min.js') }}"></script>
<script src=" {{ asset('js/bootstrap.min.js') }}"></script>
<script src=" {{ asset('js/holder.min.js') }}"></script>
@yield('js')
</body>
</html>
