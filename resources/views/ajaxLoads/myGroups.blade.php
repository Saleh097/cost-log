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
        <td id="{{$waitingJoin->get('id')}}">
            {{$waitingJoin->get('name')}} wants to join {{$waitingJoin['group_name']}}
            <button type="button" class="btn btn-primary" id="acceptButton"> accept </button>
            <button type="button" class="btn btn-outline-danger" id="declineButton"> decline </button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>