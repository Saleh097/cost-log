<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('css/Beginning.css')}}" />
        <link rel="stylesheet" href="{{url('packages/bootstrap.min.css')}}">
        <title>Laravel</title>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                height: 100vh;
            }
        </style>
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
            @if ($errors->any())
                <script>
                    alert("Error {{$errors->first()}} Occurred");
                </script>
            @endif
            <form class="col-md-4" method="POST" action="{{ route('register') }}">
                @csrf
                name:<input type="text" name="name" class="form-control" required autofocus /> <br/>
                Email: <input type="email" name="email" class="form-control" required /> <br/>
                password: <input type="password" name="password" class="form-control" required autocomplete="new-password" /> <br/>
                confirm password: <input type="password" name="password_confirmation" class="form-control" required /> <br/>
                <a href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <input name="Register" type="submit" value="Register" class="btn btn-primary">
            </form>
        </article>
    </section>
    </body>
</html>