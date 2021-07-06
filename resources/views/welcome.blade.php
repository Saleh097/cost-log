<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('css/Beginning.css')}}" />

        <title>Laravel</title>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                height: 100vh;
            }
        </style>

        <link rel="stylesheet" href="{{url('packages/bootstrap.min.css')}}">
        <script src="{{url('packages/jquery-3.6.0.js')}}"></script>
    </head>
    <body>
        <header class="container-fluid bg-primary pt-2 pb-2">
            cost log project
        </header>

        <section class="row h-100">
            <aside class="col-md-2 bg-light pt-2">
                 <p class="pl-2"> this is side bar <br>
                enjoy it! </p>
            </aside>
            <article class="col-md-10 bg-info pt-2 pl-2">
                <h3> welcome to Cost log project </h3> <br>
                <h5> you may <a href="/login"> Login </a> or <a href="/register"> Register </a> if you are new user </h5>
            </article>
        </section>
    </body>
</html>
