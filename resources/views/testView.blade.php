<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="{{url('css/Beginning.css')}}" />

    <title>Laravel</title>

    <script src="{{url('packages/jquery-3.6.0.js')}}"></script>
    <script src="{{url('packages/bootstrap.bundle.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('packages/bootstrap.min.css')}}">
    <script src="{{url('packages/popper.min.js')}}"></script>
</head>
<body>

<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Open modal
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

</body>
</html>
