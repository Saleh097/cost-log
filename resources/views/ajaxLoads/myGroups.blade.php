Groups created by you <br>
<table class="table table-dark table-striped table-hover text-center col-4">
    <thead>
    <tr>
        <th> group name </th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr id="{{$group->id}}" class="ownerGroup">
            <td> {{$group->group_name}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped col-4">
    <tbody>
    @foreach($waitingJoins as $waitingJoin)
    <tr>
        <td id="{{$waitingJoin->get('user_id')}}" name="{{$waitingJoin->get('group_id')}}">
            {{$waitingJoin->get('name')}} wants to join {{$waitingJoin['group_name']}}
            <button type="button" class="btn btn-primary acceptBtn" id="acceptButton"> accept </button>
            <button type="button" class="btn btn-outline-danger declineBtn" id="declineButton"> decline </button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<button class="btn btn-success" data-toggle="modal" data-target="#newGroupModal"> Create New Group </button>


<!-- Create New Group Modal -->
<section class="modal fade" id="newGroupModal">
    <div class="modal-dialog">
        <article class="modal-content">

            <!-- Modal Header -->
            <header class="modal-header">
                <h5 class="modal-title">Enter a name for group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </header>

            <!-- Modal body -->
            <article class="modal-body">
                <form action="/Groups/createGroup" method="post" id="createGroupForm">
                    @csrf
                    <input type="text" class="form-control" name="groupName">
                </form>
            </article>

            <!-- Modal footer -->
            <footer class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button class="btn btn-success" id="createBtn"> Create </button>
            </footer>

        </article>
    </div>
</section>

<script>
    $(document).ready(function () {
        $(".acceptBtn").click(function () {
            $.get("/Groups/acceptRequest/"+$(this).parent().attr('name')+"/"+ $(this).parent().attr('id'), function(data, status){
                alert(data);
            });
            $("#mys").trigger('click'); //to refresh current part (by ajax req)
        });
        $(".declineBtn").click(function () {
            $.get("/Groups/declineRequest/"+$(this).parent().attr('name')+"/"+ $(this).parent().attr('id'), function(data, status){
                alert(data);
            });
            $("#mys").trigger('click'); //to refresh current part (by ajax req)
        });
        $("#createBtn").click(function (){
            $("#createGroupForm").submit();
        });
        $(".ownerGroup").click(function () {
            let groupId = $(this).attr('id');
            $.post('http://localhost:8000/ajax/manageSpecificGroup', {_token:"{{csrf_token()}}" ,groupId: groupId},function (data) {
                    $("#main").html(data);
                });
        });
    });
</script>