Groups created by you <br>
<table class="table table-dark table-striped table-hover text-center col-4">
    <thead>
    <tr>
        <th> group name </th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr id="{{$group->id}}">
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
    });
</script>