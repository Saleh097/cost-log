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
    Welcome {{$userName}}
    <a href="/logout" class="btn btn-danger ml-5"> logout </a>
</header>

<section class="row h-100">
    <aside class="col-md-2 bg-light list-group">
        <a href="#" class="list-group-item list-group-item-action" id="join">  Join to a Group  </a>
        <a href="#" class="list-group-item list-group-item-action" id="joined"> Joined Groups  </a>
        <a href="#" class="list-group-item list-group-item-action" id="mys">  My Groups  </a>
    </aside>
    <article class="col-md-10 bg-info pt-2 pl-2" id="main">

    </article>
</section>

<script>
    $(document).ready(function (){
        $("#main").load("http://localhost:8000/ajax/joinToGroup");
        $("#join").click(function (){
            $("#main").text("... please wait ...");
            $("#main").load("http://localhost:8000/ajax/joinToGroup");
        });
        $("#joined").click(function (){
            $("#main").text("... please wait ...");
            $("#main").load("http://localhost:8000/ajax/joinedGroups");
        });
        $("#mys").click(function (){
            $("#main").text("... please wait ...");
            $("#main").load("http://localhost:8000/ajax/myGroups");
        });
    });


</script>

</body>
</html>
